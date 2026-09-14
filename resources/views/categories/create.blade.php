```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Category') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Category Name
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Example: Food, Transport, Bills">

                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Type
                        </label>

                        <select name="type"
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('categories.index') }}"
                           class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
```
