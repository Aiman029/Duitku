<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $budgets = Budget::with('category')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($budget) use ($userId) {
                $spent = Transaction::where('user_id', $userId)
                    ->where('category_id', $budget->category_id)
                    ->where('type', 'expense')
                    ->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)
                    ->sum('amount');

                $budget->spent = (float) $spent;
                $budget->percentage = $budget->monthly_limit > 0
                    ? round(($spent / $budget->monthly_limit) * 100, 1)
                    : 0;

                return $budget;
            });

        // Kategori expense yang belum ada budget lagi
        $categoriesWithoutBudget = Category::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereNotIn('id', $budgets->pluck('category_id'))
            ->get();

        return view('budgets.index', compact('budgets', 'categoriesWithoutBudget'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'monthly_limit' => 'required|numeric|min:0.01',
        ]);

        $validated['user_id'] = Auth::id();

        Budget::updateOrCreate(
            ['user_id' => Auth::id(), 'category_id' => $validated['category_id']],
            ['monthly_limit' => $validated['monthly_limit']]
        );

        return redirect()->route('budgets.index')->with('success', 'Budget berjaya ditetapkan.');
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorizeOwner($budget);

        $validated = $request->validate([
            'monthly_limit' => 'required|numeric|min:0.01',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')->with('success', 'Budget berjaya dikemaskini.');
    }

    public function destroy(Budget $budget)
    {
        $this->authorizeOwner($budget);
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget berjaya dipadam.');
    }

    private function authorizeOwner(Budget $budget): void
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }
    }
}