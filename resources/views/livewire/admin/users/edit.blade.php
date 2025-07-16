<x-layouts.app :title="__('Edit User')">
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Edit User: {{ $user->name }}</h2>
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6" x-data="{ role: '{{ old('role', $user->role) }}' }">
                    @csrf
                    @method('PUT')
                    <!-- Form fields here -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password <span class="text-xs text-zinc-500">(leave blank to keep)</span></label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Role</label>
                        <select name="role" id="role" x-model="role" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                            <option value="general" @if(old('role', $user->role) == 'general') selected @endif>General</option>
                            <option value="country" @if(old('role', $user->role) == 'country') selected @endif>Country</option>
                            <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
                        </select>
                        @error('role') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div x-show="role !== 'admin'" x-transition>
                        <label for="country_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Country</label>
                        <select name="country_id" id="country_id" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" @if(old('country_id', $user->country_id) == $country->id) selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('admin.users.index') }}" class="rounded-md bg-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-600">Cancel</a>
                        <button type="submit" class="rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
