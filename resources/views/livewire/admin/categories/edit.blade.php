<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-lg mx-auto">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Edit Category</h2>
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-1 font-medium" for="name">Name</label>
                        <input type="text" name="name" id="name" class="input w-full"
                            value="{{ old('name', $category->name) }}" required autocomplete="off">
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="description">Description</label>
                        <textarea name="description" id="description" class="input w-full"
                            rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="icon">Icon</label>
                        <input type="text" name="icon" id="icon" class="input w-full"
                            value="{{ old('icon', $category->icon) }}" autocomplete="off">
                        @error('icon') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
