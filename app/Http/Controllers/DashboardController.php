<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $previousMonthDate = now()->subMonth();
        $previousMonth = $previousMonthDate->month;
        $previousYear = $previousMonthDate->year;

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        // ===== Perbandingan bulan lepas =====
        $previousExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', $previousMonth)
            ->whereYear('date', $previousYear)
            ->sum('amount');

        $previousIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', $previousMonth)
            ->whereYear('date', $previousYear)
            ->sum('amount');

        $expenseComparison = $this->calculateComparison($totalExpense, $previousExpense);
        $incomeComparison = $this->calculateComparison($totalIncome, $previousIncome);

        // Data untuk pie chart: expense ikut kategori (bulan ni)
        $expenseByCategory = Transaction::with('category')
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->category->name ?? 'Tiada Kategori',
                    'total' => (float) $item->total,
                ];
            });

        // Data untuk line/bar chart: trend 6 bulan terakhir
        $monthlyTrend = Transaction::where('user_id', $userId)
            ->where('date', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();

        $recentTransactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->latest('date')
            ->take(5)
            ->get();

        // Budget alerts: kategori yang dah >= 80% guna had bulanan
        $budgetAlerts = Budget::with('category')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($budget) use ($userId, $currentMonth, $currentYear) {
                $spent = Transaction::where('user_id', $userId)
                    ->where('category_id', $budget->category_id)
                    ->where('type', 'expense')
                    ->whereMonth('date', $currentMonth)
                    ->whereYear('date', $currentYear)
                    ->sum('amount');

                $percentage = $budget->monthly_limit > 0
                    ? round(($spent / $budget->monthly_limit) * 100, 1)
                    : 0;

                return [
                    'category' => $budget->category->name ?? 'Tiada Kategori',
                    'spent' => (float) $spent,
                    'limit' => (float) $budget->monthly_limit,
                    'percentage' => $percentage,
                    'status' => $percentage >= 100 ? 'over' : ($percentage >= 80 ? 'near' : 'ok'),
                ];
            })
            ->filter(fn ($item) => $item['status'] !== 'ok')
            ->values();

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'expenseByCategory',
            'monthlyTrend',
            'recentTransactions',
            'budgetAlerts',
            'expenseComparison',
            'incomeComparison'
        ));
    }

    /**
     * Kira peratus perubahan antara bulan ni vs bulan lepas.
     * Return array: ['percentage' => float, 'direction' => 'up'|'down'|'same', 'previous' => float]
     */
    private function calculateComparison(float $current, float $previous): array
    {
        if ($previous <= 0) {
            // Takde data bulan lepas untuk banding — anggap 'same' supaya tak paparkan angka mengelirukan
            return [
                'percentage' => 0,
                'direction' => 'same',
                'previous' => (float) $previous,
                'has_previous_data' => false,
            ];
        }

        $diff = $current - $previous;
        $percentage = round((abs($diff) / $previous) * 100, 1);

        $direction = 'same';
        if ($diff > 0) {
            $direction = 'up';
        } elseif ($diff < 0) {
            $direction = 'down';
        }

        return [
            'percentage' => $percentage,
            'direction' => $direction,
            'previous' => (float) $previous,
            'has_previous_data' => true,
        ];
    }
}