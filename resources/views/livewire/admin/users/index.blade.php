<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Users</h2>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
            </div>
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($users as $user)
                                            <tr
                                                class="hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors {{ $loop->even ? 'bg-zinc-50 dark:bg-zinc-900' : 'bg-white dark:bg-zinc-800' }}">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold {{
                            $user->role === 'admin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' :
                            ($user->role === 'general' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200')
                                                        }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                                    <a href="{{ route('admin.users.edit', $user) }}"
                                                        class="btn btn-sm btn-secondary">Edit</a>
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
