<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = SavingsGoal::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('savings-goals.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'target_date' => 'nullable|date',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_amount'] = 0;

        SavingsGoal::create($validated);

        return redirect()->route('savings-goals.index')->with('success', 'Matlamat simpanan berjaya ditambah.');
    }

    public function contribute(Request $request, SavingsGoal $savingsGoal)
    {
        $this->authorizeOwner($savingsGoal);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $savingsGoal->increment('current_amount', $validated['amount']);

        return redirect()->route('savings-goals.index')->with('success', 'Duit berjaya ditambah ke matlamat simpanan.');
    }

    public function update(Request $request, SavingsGoal $savingsGoal)
    {
        $this->authorizeOwner($savingsGoal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'target_date' => 'nullable|date',
        ]);

        $savingsGoal->update($validated);

        return redirect()->route('savings-goals.index')->with('success', 'Matlamat simpanan berjaya dikemaskini.');
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        $this->authorizeOwner($savingsGoal);
        $savingsGoal->delete();

        return redirect()->route('savings-goals.index')->with('success', 'Matlamat simpanan berjaya dipadam.');
    }

    private function authorizeOwner(SavingsGoal $savingsGoal): void
    {
        if ($savingsGoal->user_id !== Auth::id()) {
            abort(403);
        }
    }
}