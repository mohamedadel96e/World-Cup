<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-lg mx-auto">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Add Weapon</h2>
                <form action="{{ route('admin.weapons.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf
                    <div>
                        <label class="block mb-1 font-medium" for="name">Name</label>
                        <input type="text" name="name" id="name" class="input w-full" value="{{ old('name') }}" required
                            autocomplete="off">
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="description">Description</label>
                        <textarea name="description" id="description" class="input w-full"
                            rows="3">{{ old('description') }}</textarea>
                        @error('description') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="input w-full" required>
                            <option value="">Select Category</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="country_id">Country</label>
                        <select name="country_id" id="country_id" class="input w-full" required>
                            <option value="">Select Country</option>
                            @foreach(\App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>
                                    {{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium" for="base_price">Base Price</label>
                            <input type="number" name="base_price" id="base_price" class="input w-full"
                                value="{{ old('base_price', 0) }}" min="0" required>
                            @error('base_price') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium" for="manufacturer_price">Manufacturer Price</label>
                            <input type="number" name="manufacturer_price" id="manufacturer_price" class="input w-full"
                                value="{{ old('manufacturer_price', 0) }}" min="0" required>
                            @error('manufacturer_price') <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium" for="discount_percentage">Discount %</label>
                            <input type="number" name="discount_percentage" id="discount_percentage"
                                class="input w-full" value="{{ old('discount_percentage', 0) }}" min="0" max="100"
                                required>
                            @error('discount_percentage') <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium" for="image_path">Image</label>
                            <input type="file" name="image_path" id="image_path" class="input w-full">
                            @error('image_path') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_available" value="1" class="form-checkbox"
                                @if(old('is_available', true)) checked @endif>
                            <span class="ml-2">Available</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" class="form-checkbox"
                                @if(old('is_featured')) checked @endif>
                            <span class="ml-2">Featured</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('admin.weapons.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Weapon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
