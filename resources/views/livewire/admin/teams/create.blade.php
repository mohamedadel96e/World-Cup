<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-lg mx-auto">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Add Team</h2>
                <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data"
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
                        <label class="block mb-1 font-medium" for="logo">Logo</label>
                        <input type="file" name="logo" id="logo" class="input w-full">
                        @error('logo') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Team</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
