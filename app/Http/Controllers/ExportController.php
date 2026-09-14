<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function pdf(Request $request)
    {
        $transactions = $this->filteredTransactions($request)->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        $pdf = Pdf::loadView('exports.transactions_pdf', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'from' => $request->from,
            'to' => $request->to,
        ]);

        return $pdf->download('laporan-transaksi-' . now()->format('Y-m-d') . '.pdf');
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new TransactionsExport($request->from, $request->to, $request->type, $request->category_id),
            'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    private function filteredTransactions(Request $request)
    {
        $query = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('date');

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

        return $query;
    }
}