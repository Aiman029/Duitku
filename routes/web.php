<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SavingsGoalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/savings-goals', [SavingsGoalController::class, 'index'])->name('savings-goals.index');
    Route::post('/savings-goals', [SavingsGoalController::class, 'store'])->name('savings-goals.store');
    Route::put('/savings-goals/{savingsGoal}', [SavingsGoalController::class, 'update'])->name('savings-goals.update');
    Route::delete('/savings-goals/{savingsGoal}', [SavingsGoalController::class, 'destroy'])->name('savings-goals.destroy');
    Route::post('/savings-goals/{savingsGoal}/contribute', [SavingsGoalController::class, 'contribute'])->name('savings-goals.contribute');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('budgets', BudgetController::class)->except(['create', 'edit', 'show']);
    Route::get('/transactions-export/pdf', [ExportController::class, 'pdf'])->name('transactions.export.pdf');
Route::get('/transactions-export/excel', [ExportController::class, 'excel'])->name('transactions.export.excel');
});

require __DIR__.'/auth.php';