<x-layouts.app :title="__('Add New Team')">
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Create New Team</h2>
                <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Team Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('name') }}" required>
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500">{{ old('description') }}</textarea>
                        @error('description') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="logo" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Team Logo</label>
                        <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-200 file:px-4 file:py-2 dark:file:bg-zinc-700 dark:file:text-zinc-300">
                        @error('logo') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex justify-end gap-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <a href="{{ route('admin.teams.index') }}" class="rounded-md bg-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-800 shadow-sm hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-600">Cancel</a>
                        <button type="submit" class="rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500">Create Team</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
