<x-layouts.app :title="__('Add New Country')">
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Create New Country</h2>
                <form action="{{ route('admin.countries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Form fields here -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Country Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('name') }}" required>
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Country Code (3 Letters)</label>
                            <input type="text" name="code" id="code" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('code') }}" required>
                            @error('code') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="team_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Team</label>
                            <select name="team_id" id="team_id" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                                <option value="">Select Team</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" @if(old('team_id') == $team->id) selected @endif>{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('team_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="currency_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Currency Name</label>
                            <input type="text" name="currency_name" id="currency_name" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('currency_name') }}" required>
                            @error('currency_name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="currency_code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Currency Code</label>
                            <input type="text" name="currency_code" id="currency_code" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('currency_code') }}" required>
                            @error('currency_code') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="currency_symbol" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Symbol</label>
                            <input type="text" name="currency_symbol" id="currency_symbol" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('currency_symbol') }}" required>
                            @error('currency_symbol') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="balance" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Starting Balance</label>
                        <input type="number" name="balance" id="balance" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('balance', 1000000) }}" required>
                        @error('balance') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="logo" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Logo</label>
                            <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-200 file:px-4 file:py-2 dark:file:bg-zinc-700 dark:file:text-zinc-300">
                            @error('logo') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="flag" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Flag</label>
                            <input type="file" name="flag" id="flag" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:rounded-md file:border-0 file:bg-zinc-200 file:px-4 file:py-2 dark:file:bg-zinc-700 dark:file:text-zinc-300">
                            @error('flag') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <a href="{{ route('admin.countries.index') }}" class="rounded-md bg-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-800 shadow-sm hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-600">Cancel</a>
                        <button type="submit" class="rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500">Create Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
