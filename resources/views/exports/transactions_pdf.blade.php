```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h2 { margin-bottom: 0; }
        p.subtitle { color: #666; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        .text-right { text-align: right; }
        .income { color: #16a34a; }
        .expense { color: #dc2626; }
        .summary { margin-top: 16px; }
        .summary td { border: none; padding: 2px 8px; }
    </style>
</head>
<body>
    <h2>Transaction Report</h2>
    <p class="subtitle">
        Generated on: {{ now()->format('d/m/Y H:i') }}
        @if ($from || $to)
            | Period: {{ $from ?: '-' }} to {{ $to ?: '-' }}
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Type</th>
                <th>Description</th>
                <th class="text-right">Amount (RM)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $tx)
                <tr>
                    <td>{{ $tx->date->format('d/m/Y') }}</td>
                    <td>{{ $tx->category->name ?? '-' }}</td>
                    <td>{{ $tx->type === 'income' ? 'Income' : 'Expense' }}</td>
                    <td>{{ $tx->description ?: '-' }}</td>
                    <td class="text-right {{ $tx->type === 'income' ? 'income' : 'expense' }}">
                        {{ $tx->type === 'income' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td><strong>Total Income:</strong></td>
            <td class="income">RM {{ number_format($totalIncome, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total Expenses:</strong></td>
            <td class="expense">RM {{ number_format($totalExpense, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Balance:</strong></td>
            <td>RM {{ number_format($totalIncome - $totalExpense, 2) }}</td>
        </tr>
    </table>
</body>
</html>
```
