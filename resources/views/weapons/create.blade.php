<x-layouts.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Add New Weapon to Your Arsenal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <form action="{{ route('weapons.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Weapon Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Weapon Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-900">
                        @error('name') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Category</label>
                        <select name="category_id" id="category_id" required class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-900">
                            <option value="">Select a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-900">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base Price (in {{ $country->currency_code }})</label>
                            <input type="number" name="base_price" id="base_price" value="{{ old('base_price') }}" required class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-900">
                            @error('base_price') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="discount_percentage" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Discount Percentage (%)</label>
                            <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', 0) }}" class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-900">
                            @error('discount_percentage') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>


                    <!-- Image Upload -->
                    <div x-data="{ imagePreview: null }">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Weapon Image</label>

                        <!-- The file input is now outside the conditional templates -->
                        <input id="image_path" name="image_path" type="file" class="sr-only" x-ref="image_input" @change="imagePreview = URL.createObjectURL($event.target.files[0])">

                        <div
                            @dragover.prevent @drop.prevent="
                                let files = $event.dataTransfer.files;
                                if (files.length > 0) {
                                    $refs.image_input.files = files;
                                    $refs.image_input.dispatchEvent(new Event('change'));
                                }
                            "
                            class="mt-1 flex justify-center rounded-lg border border-dashed border-zinc-900/25 px-6 py-10 dark:border-zinc-100/25"
                        >
                            <div class="text-center">
                                <template x-if="!imagePreview">
                                    <label for="image_path" class="relative cursor-pointer">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                          <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12A2.25 2.25 0 0120.25 20.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                            <span class="rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500 dark:bg-transparent dark:text-blue-400 dark:hover:text-blue-300">
                                                <span>Upload a file</span>
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, WEBP up to 4MB</p>
                                    </label>
                                </template>
                                <template x-if="imagePreview">
                                    <div class="relative">
                                        <img :src="imagePreview" class="mx-auto h-48 w-auto rounded-md">
                                        <button @click="imagePreview = null; $refs.image_input.value = null;" type="button" class="absolute -top-2 -right-2 rounded-full bg-red-600 p-1 text-white shadow-sm hover:bg-red-500 focus:outline-none">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        @error('image_path') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="rounded-md bg-blue-600 px-8 py-3 text-base font-semibold text-white shadow-lg transition-transform hover:scale-105 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Add Weapon to Arsenal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
