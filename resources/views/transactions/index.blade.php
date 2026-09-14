```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center">
                <h3 class="text-gray-600 text-sm">
                    List of all transactions
                </h3>

                <div class="flex gap-2">
                    <a href="{{ route('transactions.export.pdf', request()->query()) }}"
                       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
                        Export PDF
                    </a>

                    <a href="{{ route('transactions.export.excel', request()->query()) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                        Export Excel
                    </a>

                    <a href="{{ route('transactions.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                        + Add Transaction
                    </a>
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-xl shadow p-4">
                <form action="{{ route('transactions.index') }}"
                      method="GET"
                      class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">

                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-500 mb-1">
                            Search Description
                        </label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Example: food, petrol..."
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            Type
                        </label>

                        <select name="type"
                                class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">All</option>
                            <option value="income"
                                    @selected(request('type') === 'income')>
                                Income
                            </option>
                            <option value="expense"
                                    @selected(request('type') === 'expense')>
                                Expense
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            Category
                        </label>

                        <select name="category_id"
                                class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">All</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @selected(request('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            From Date
                        </label>

                        <input type="date"
                               name="from"
                               value="{{ request('from') }}"
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div class="flex gap-2">
                        <input type="date"
                               name="to"
                               value="{{ request('to') }}"
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div class="md:col-span-6 flex gap-2 justify-end">
                        <a href="{{ route('transactions.index') }}"
                           class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                            Reset
                        </a>

                        <button type="submit"
                                class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-900">
                            Filter
                        </button>
                    </div>

                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50">
                        <tr class="text-left text-gray-500">
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Category</th>
                            <th class="px-6 py-3">Description</th>
                            <th class="px-6 py-3 text-right">Amount</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($transactions as $tx)

                            <tr class="border-t">
                                <td class="px-6 py-3">
                                    {{ $tx->date->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-3">
                                    {{ $tx->category->name ?? '-' }}
                                </td>

                                <td class="px-6 py-3">
                                    {{ $tx->description ?: '-' }}
                                </td>

                                <td class="px-6 py-3 text-right {{ $tx->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->type === 'income' ? '+' : '-' }}RM
                                    {{ number_format($tx->amount, 2) }}
                                </td>

                                <td class="px-6 py-3 text-right space-x-2">

                                    <a href="{{ route('transactions.edit', $tx) }}"
                                       class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('transactions.destroy', $tx) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-6 py-6 text-center text-gray-400">
                                    No transactions found.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

            <div>
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
```
    