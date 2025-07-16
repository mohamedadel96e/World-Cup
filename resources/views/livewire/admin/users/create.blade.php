<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-lg mx-auto">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Add User</h2>
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block mb-1 font-medium" for="name">Name</label>
                        <input type="text" name="name" id="name" class="input w-full" value="{{ old('name') }}" required
                            autocomplete="off">
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="email">Email</label>
                        <input type="email" name="email" id="email" class="input w-full" value="{{ old('email') }}"
                            required autocomplete="off">
                        @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block mb-1 font-medium" for="password">Password</label>
                            <input type="password" name="password" id="password" class="input w-full" required>
                            @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="flex-1">
                            <label class="block mb-1 font-medium" for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="input w-full" required>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" for="role">Role</label>
                        <select name="role" id="role" class="input w-full" required>
                            <option value="">Select Role</option>
                            <option value="admin" @if(old('role') == 'admin') selected @endif>Admin</option>
                            <option value="general" @if(old('role') == 'general') selected @endif>General</option>
                            <option value="country" @if(old('role') == 'country') selected @endif>Country</option>
                        </select>
                        @error('role') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
