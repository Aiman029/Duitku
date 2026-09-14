```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Type
                        </label>

                        <select name="type"
                                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="expense"
                                @selected(old('type', $transaction->type) === 'expense')>
                                Expense
                            </option>

                            <option value="income"
                                @selected(old('type', $transaction->type) === 'income')>
                                Income
                            </option>
                        </select>

                        @error('type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Category
                        </label>

                        <select name="category_id"
                                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        data-type="{{ $category->type }}"
                                        @selected(old('category_id', $transaction->category_id) == $category->id)>
                                    {{ $category->name }}
                                    ({{ $category->type === 'income' ? 'Income' : 'Expense' }})
                                </option>
                            @endforeach

                        </select>

                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Amount (RM)
                        </label>

                        <input type="number"
                               step="0.01"
                               name="amount"
                               value="{{ old('amount', $transaction->amount) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('amount')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Date
                        </label>

                        <input type="date"
                               name="date"
                               value="{{ old('date', $transaction->date->format('Y-m-d')) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description (optional)
                        </label>

                        <input type="text"
                               name="description"
                               value="{{ old('description', $transaction->description) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('transactions.index') }}"
                           class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.querySelector('select[name="type"]');
            const categorySelect = document.querySelector('select[name="category_id"]');

            if (!typeSelect || !categorySelect) return;

            function filterCategories() {
                const selectedType = typeSelect.value;
                const currentValue = categorySelect.value;
                let hasVisibleSelected = false;

                Array.from(categorySelect.options).forEach(function (option) {
                    if (!option.dataset.type) return;

                    const matches = option.dataset.type === selectedType;

                    option.hidden = !matches;
                    option.disabled = !matches;

                    if (matches && option.value === currentValue) {
                        hasVisibleSelected = true;
                    }
                });

                if (!hasVisibleSelected) {
                    const firstMatch = Array.from(categorySelect.options).find(
                        (opt) => opt.dataset.type === selectedType
                    );

                    if (firstMatch) {
                        categorySelect.value = firstMatch.value;
                    }
                }
            }

            typeSelect.addEventListener('change', filterCategories);
            filterCategories();
        });
    </script>
    @endpush

</x-app-layout>
```
