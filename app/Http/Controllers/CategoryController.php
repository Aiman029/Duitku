<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['user_id'] = Auth::id();

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berjaya ditambah.');
    }

    public function edit(Category $category)
    {
        $this->authorizeOwner($category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeOwner($category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berjaya dikemaskini.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeOwner($category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berjaya dipadam.');
    }

    private function authorizeOwner(Category $category): void
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
    }
}