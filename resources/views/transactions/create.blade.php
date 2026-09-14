```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">

                @if ($categories->isEmpty())
                    <p class="text-gray-500 text-sm">
                        You don't have any categories yet.
                        <a href="{{ route('categories.create') }}"
                           class="text-blue-600 hover:underline">
                            Add a category first
                        </a>
                        before you can record a transaction.
                    </p>
                @else

                <form action="{{ route('transactions.store') }}"
                      method="POST"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Type
                        </label>

                        <select name="type"
                                id="type"
                                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="expense"
                                    @selected(old('type') === 'expense')>
                                Expense
                            </option>

                            <option value="income"
                                    @selected(old('type') === 'income')>
                                Income
                            </option>
                        </select>

                        @error('type')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
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
                                        @selected(old('category_id') == $category->id)>

                                    {{ $category->name }}
                                    ({{ $category->type === 'income' ? 'Income' : 'Expense' }})

                                </option>
                            @endforeach

                        </select>

                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Amount (RM)
                        </label>

                        <input type="number"
                               step="0.01"
                               name="amount"
                               value="{{ old('amount') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0.00">

                        @error('amount')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Date
                        </label>

                        <input type="date"
                               name="date"
                               value="{{ old('date', date('Y-m-d')) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('date')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description (optional)
                        </label>

                        <input type="text"
                               name="description"
                               value="{{ old('description') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Example: Lunch at the cafeteria">

                        @error('description')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">

                        <a href="{{ route('transactions.index') }}"
                           class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Save
                        </button>

                    </div>
                </form>

                @endif

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

            </div>
        </div>
    </div>
</x-app-layout>
```
