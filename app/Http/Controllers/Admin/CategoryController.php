<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('weapons')->latest()->paginate(10);
        return view('livewire.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('livewire.admin.categories.create');
    }

    public function store(StoreCategoryRequest $request, CloudinaryUploadService $cloudinary)
    {
        $validated = $request->validated();

        if ($request->hasFile('icon')) {
            $folder = 'category_icons';
            $publicId = Str::slug($validated['name']);
            $validated['icon'] = $cloudinary->upload($request->file('icon'), $folder, $publicId);
        }

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('livewire.admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category, CloudinaryUploadService $cloudinary)
    {
        $validated = $request->validated();

        if ($request->hasFile('icon')) {
            $folder = 'category_icons';
            $publicId = Str::slug($validated['name']);
            $validated['icon'] = $cloudinary->upload($request->file('icon'), $folder, $publicId);
        }

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Prevent deletion if the category is assigned to any weapons
        if ($category->weapons()->exists()) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete a category that is currently in use.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
