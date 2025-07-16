<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('livewire.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('livewire.admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);
        try {
            Category::create($validated);
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not create category: ' . $e->getMessage()]);
        }
    }

    public function edit(Category $category)
    {
        return view('livewire.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);
        try {
            $category->update($validated);
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not update category: ' . $e->getMessage()]);
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
