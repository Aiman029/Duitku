```blade id="9kgl07"
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monthly Budget') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Set New Budget --}}
            @if ($categoriesWithoutBudget->isNotEmpty())
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-3">
                        Set a New Budget
                    </h3>

                    <form action="{{ route('budgets.store') }}"
                          method="POST"
                          class="flex flex-col md:flex-row gap-3">
                        @csrf

                        <select name="category_id"
                                class="flex-1 rounded-lg border-gray-300 text-sm">

                            @foreach ($categoriesWithoutBudget as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                        <input type="number"
                               step="0.01"
                               name="monthly_limit"
                               placeholder="Monthly Limit (RM)"
                               class="flex-1 rounded-lg border-gray-300 text-sm"
                               required>

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 whitespace-nowrap">
                            Set Budget
                        </button>
                    </form>

                    @error('category_id')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                    @error('monthly_limit')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif

            {{-- Existing Budgets --}}
            <div class="space-y-3">

                @forelse ($budgets as $budget)

                    @php
                        $barColor = $budget->percentage >= 100
                            ? 'bg-red-500'
                            : ($budget->percentage >= 80
                                ? 'bg-yellow-500'
                                : 'bg-green-500');
                    @endphp

                    <div class="bg-white rounded-xl shadow p-5">

                        <div class="flex justify-between items-center mb-2">

                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $budget->category->name ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    RM {{ number_format($budget->spent, 2) }}
                                    /
                                    RM {{ number_format($budget->monthly_limit, 2) }}
                                    ({{ $budget->percentage }}%)
                                </p>
                            </div>

                            <div class="flex gap-3 text-sm">

                                <form action="{{ route('budgets.update', $budget) }}"
                                      method="POST"
                                      class="flex gap-2 items-center">
                                    @csrf
                                    @method('PUT')

                                    <input type="number"
                                           step="0.01"
                                           name="monthly_limit"
                                           value="{{ $budget->monthly_limit }}"
                                           class="w-24 rounded-lg border-gray-300 text-xs">

                                    <button type="submit"
                                            class="text-blue-600 hover:underline text-xs">
                                        Update
                                    </button>
                                </form>

                                <form action="{{ route('budgets.destroy', $budget) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this budget?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:underline text-xs">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="{{ $barColor }} h-2.5 rounded-full"
                                 style="width: {{ min($budget->percentage, 100) }}%">
                            </div>
                        </div>

                        @if ($budget->percentage >= 100)
                            <p class="text-red-600 text-xs mt-2">
                                ⚠️ You have exceeded the budget limit for this category!
                            </p>

                        @elseif ($budget->percentage >= 80)
                            <p class="text-yellow-600 text-xs mt-2">
                                ⚠️ You are approaching the budget limit — spend carefully.
                            </p>
                        @endif

                    </div>

                @empty

                    <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400 text-sm">
                        No budgets have been set yet.
                    </div>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>
```
