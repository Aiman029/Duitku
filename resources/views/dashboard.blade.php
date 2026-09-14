```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Total Income (This Month)</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">
                        RM {{ number_format($totalIncome, 2) }}
                    </p>
                    @if ($incomeComparison['has_previous_data'])
                        <p class="text-xs mt-2 flex items-center gap-1
                            {{ $incomeComparison['direction'] === 'up' ? 'text-green-600' : ($incomeComparison['direction'] === 'down' ? 'text-red-500' : 'text-gray-400') }}">
                            @if ($incomeComparison['direction'] === 'up')
                                ▲ {{ $incomeComparison['percentage'] }}% more than last month
                            @elseif ($incomeComparison['direction'] === 'down')
                                ▼ {{ $incomeComparison['percentage'] }}% less than last month
                            @else
                                Same as last month
                            @endif
                        </p>
                    @else
                        <p class="text-xs text-gray-400 mt-2">No data from last month to compare</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Total Expenses (This Month)</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">
                        RM {{ number_format($totalExpense, 2) }}
                    </p>
                    @if ($expenseComparison['has_previous_data'])
                        <p class="text-xs mt-2 flex items-center gap-1
                            {{ $expenseComparison['direction'] === 'up' ? 'text-red-500' : ($expenseComparison['direction'] === 'down' ? 'text-green-600' : 'text-gray-400') }}">
                            @if ($expenseComparison['direction'] === 'up')
                                ▲ {{ $expenseComparison['percentage'] }}% more than last month
                            @elseif ($expenseComparison['direction'] === 'down')
                                ▼ {{ $expenseComparison['percentage'] }}% less than last month
                            @else
                                Same as last month
                            @endif
                        </p>
                    @else
                        <p class="text-xs text-gray-400 mt-2">No data from last month to compare</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Balance</p>
                    <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }} mt-1">
                        RM {{ number_format($balance, 2) }}
                    </p>
                </div>
            </div>

            @if ($budgetAlerts->isNotEmpty())
            <div class="space-y-2">
                @foreach ($budgetAlerts as $alert)
                    <div class="rounded-xl p-4 flex justify-between items-center
                        {{ $alert['status'] === 'over' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200' }}">
                        <div>
                            <p class="font-medium {{ $alert['status'] === 'over' ? 'text-red-700' : 'text-yellow-700' }}">
                                {{ $alert['status'] === 'over' ? '⚠️ Budget Exceeded' : '⚠️ Approaching Budget Limit' }}: {{ $alert['category'] }}
                            </p>
                            <p class="text-sm text-gray-600">
                                RM {{ number_format($alert['spent'], 2) }} / RM {{ number_format($alert['limit'], 2) }}
                                ({{ $alert['percentage'] }}%)
                            </p>
                        </div>
                        <a href="{{ route('budgets.index') }}" class="text-sm underline {{ $alert['status'] === 'over' ? 'text-red-700' : 'text-yellow-700' }}">
                            Manage Budget
                        </a>
                    </div>
                @endforeach
            </div>
            @endif

            {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Expenses by Category (This Month)</h3>
                    @if ($expenseByCategory->isEmpty())
                        <p class="text-gray-400 text-sm">No expense data yet.</p>
                    @else
                    <div class="h-72">
                        <canvas id="categoryPieChart"></canvas>
                     </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">6-Month Trend</h3>
                   <div class="h-72">
                        <canvas id="trendBarChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-700">Recent Transactions</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:underline">
                        View All &rarr;
                    </a>
                </div>

                @if ($recentTransactions->isEmpty())
                    <p class="text-gray-400 text-sm">
                        No transactions yet.
                        <a href="{{ route('transactions.create') }}" class="text-blue-600 hover:underline">
                            Add one now
                        </a>.
                    </p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="pb-2">Date</th>
                                <th class="pb-2">Category</th>
                                <th class="pb-2">Description</th>
                                <th class="pb-2 text-right">Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($recentTransactions as $tx)
                                <tr class="border-b last:border-0">
                                    <td class="py-2">{{ $tx->date->format('d/m/Y') }}</td>
                                    <td class="py-2">{{ $tx->category->name ?? '-' }}</td>
                                    <td class="py-2">{{ $tx->description ?: '-' }}</td>
                                    <td class="py-2 text-right {{ $tx->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $tx->type === 'income' ? '+' : '-' }}RM {{ number_format($tx->amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Pie chart: expenses by category
        @if ($expenseByCategory->isNotEmpty())
        new Chart(document.getElementById('categoryPieChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($expenseByCategory->pluck('label')) !!},
                datasets: [{
                    data: {!! json_encode($expenseByCategory->pluck('total')) !!},
                    backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899'],
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        @endif

        // Bar chart: income vs expense trend per month
        const trendRaw = {!! json_encode($monthlyTrend) !!};
        const months = [...new Set(trendRaw.map(item => item.month))].sort();
        const incomeData = months.map(m => {
            const found = trendRaw.find(item => item.month === m && item.type === 'income');
            return found ? parseFloat(found.total) : 0;
        });
        const expenseData = months.map(m => {
            const found = trendRaw.find(item => item.month === m && item.type === 'expense');
            return found ? parseFloat(found.total) : 0;
        });

        new Chart(document.getElementById('trendBarChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    { label: 'Income', data: incomeData, backgroundColor: '#22c55e' },
                    { label: 'Expenses', data: expenseData, backgroundColor: '#ef4444' },
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>
    @endpush
</x-app-layout>
```
