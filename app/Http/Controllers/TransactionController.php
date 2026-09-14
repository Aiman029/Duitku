<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Notifications\BudgetLimitExceeded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->latest('date');

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $transactions = $query->paginate(15)->withQueryString();
        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        $this->validateCategoryMatchesType($validated['category_id'], $validated['type']);

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        if ($validated['type'] === 'expense') {
            $this->checkBudgetAndNotify($validated['category_id']);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berjaya ditambah.');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);
        $categories = Category::where('user_id', Auth::id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeOwner($transaction);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        $this->validateCategoryMatchesType($validated['category_id'], $validated['type']);

        $transaction->update($validated);

        if ($validated['type'] === 'expense') {
            $this->checkBudgetAndNotify($validated['category_id']);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berjaya dikemaskini.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeOwner($transaction);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berjaya dipadam.');
    }

    /**
     * Pastikan kategori yang dipilih memang jenis yang sama
     * dengan jenis transaksi (income/expense).
     */
    private function validateCategoryMatchesType(int $categoryId, string $type): void
    {
        $category = Category::where('id', $categoryId)
            ->where('user_id', Auth::id())
            ->first();

        if (! $category || $category->type !== $type) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'category_id' => 'Kategori yang dipilih tidak sepadan dengan jenis transaksi (' .
                    ($type === 'income' ? 'Pendapatan' : 'Perbelanjaan') . ').',
            ]);
        }
    }

    /**
     * Check budget untuk kategori ni, dan hantar email notification
     * kalau spending dah melebihi had bulanan — tapi cuma SEKALI
     * setiap bulan supaya tak spam.
     */
    private function checkBudgetAndNotify(int $categoryId): void
    {
        $userId = Auth::id();

        $budget = Budget::with('category')
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->first();

        if (! $budget) {
            return; // takde budget ditetapkan untuk kategori ni
        }

        $currentMonth = now()->format('Y-m');

        $spent = Transaction::where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $isOverBudget = $budget->monthly_limit > 0 && $spent >= $budget->monthly_limit;
        $alreadyNotifiedThisMonth = $budget->last_notified_month === $currentMonth;

        if ($isOverBudget && ! $alreadyNotifiedThisMonth) {
            Auth::user()->notify(new BudgetLimitExceeded($budget, (float) $spent));
            $budget->update(['last_notified_month' => $currentMonth]);
        }
    }

    private function authorizeOwner(Transaction $transaction): void
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
    }
}