```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    + Add Category
                </a>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-gray-500">
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-t">
                                <td class="px-6 py-3">
                                    {{ $category->name }}
                                </td>

                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $category->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $category->type === 'income' ? 'Income' : 'Expense' }}
                                    </span>
                                </td>

                                <td class="px-6 py-3 text-right space-x-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                                <td colspan="3"
                                    class="px-6 py-6 text-center text-gray-400">
                                    No categories yet.
                                    <a href="{{ route('categories.create') }}"
                                       class="text-blue-600 hover:underline">
                                        Add one now
                                    </a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
```
