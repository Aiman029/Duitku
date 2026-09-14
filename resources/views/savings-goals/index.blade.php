```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Savings Goals') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Create a New Savings Goal --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-3">
                    Set a New Savings Goal
                </h3>

                <form action="{{ route('savings-goals.store') }}" method="POST"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf

                    <input type="text"
                           name="title"
                           placeholder="Example: New Laptop"
                           value="{{ old('title') }}"
                           class="md:col-span-2 rounded-lg border-gray-300 text-sm"
                           required>

                    <input type="number"
                           step="0.01"
                           name="target_amount"
                           placeholder="Target Amount (RM)"
                           value="{{ old('target_amount') }}"
                           class="rounded-lg border-gray-300 text-sm"
                           required>

                    <input type="date"
                           name="target_date"
                           value="{{ old('target_date') }}"
                           class="rounded-lg border-gray-300 text-sm"
                           title="Target date (optional)">

                    <div class="md:col-span-4 flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                            Set Goal
                        </button>
                    </div>
                </form>

                @error('title')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror

                @error('target_amount')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Savings Goals List --}}
            <div class="space-y-3">
                @forelse ($goals as $goal)

                    <div class="bg-white rounded-xl shadow p-5">

                        <div class="flex justify-between items-start mb-2">

                            <div>
                                <p class="font-medium text-gray-800 flex items-center gap-2">
                                    {{ $goal->title }}

                                    @if ($goal->is_complete)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                            Achieved 🎉
                                        </span>
                                    @endif
                                </p>

                                <p class="text-xs text-gray-500">
                                    RM {{ number_format($goal->current_amount, 2) }}
                                    /
                                    RM {{ number_format($goal->target_amount, 2) }}

                                    ({{ $goal->percentage }}%)

                                    @if ($goal->target_date)
                                        &middot; Target Date:
                                        {{ $goal->target_date->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>

                            <form action="{{ route('savings-goals.destroy', $goal) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this savings goal?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline text-xs">
                                    Delete
                                </button>
                            </form>

                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mb-3">
                            <div class="{{ $goal->is_complete ? 'bg-green-500' : 'bg-blue-500' }} h-2.5 rounded-full"
                                 style="width: {{ $goal->percentage }}%">
                            </div>
                        </div>

                        {{-- Add Savings --}}
                        @unless ($goal->is_complete)

                            <form action="{{ route('savings-goals.contribute', $goal) }}"
                                  method="POST"
                                  class="flex gap-2">
                                @csrf

                                <input type="number"
                                       step="0.01"
                                       name="amount"
                                       placeholder="Add Amount (RM)"
                                       class="flex-1 rounded-lg border-gray-300 text-xs"
                                       required>

                                <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-green-700 whitespace-nowrap">
                                    + Add
                                </button>
                            </form>

                        @endunless

                    </div>

                @empty

                    <div class="bg-white rounded-xl shadow p-6 text-center text-gray-400 text-sm">
                        No savings goals yet. Set your first savings goal above!
                    </div>

                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
```
