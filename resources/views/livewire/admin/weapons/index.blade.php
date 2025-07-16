<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Weapons</h2>
                <a href="{{ route('admin.weapons.create') }}" class="btn btn-primary">Add Weapon</a>
            </div>
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Country</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Base Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Manufacturer Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Discount %</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Image</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Available</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Featured</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($weapons as $weapon)
                            <tr
                                class="hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors {{ $loop->even ? 'bg-zinc-50 dark:bg-zinc-900' : 'bg-white dark:bg-zinc-800' }}">
                                <td class="px-4 py-3">{{ $weapon->id }}</td>
                                <td class="px-4 py-3 font-medium">{{ $weapon->name }}</td>
                                <td class="px-4 py-3 max-w-xs truncate">{{ $weapon->description }}</td>
                                <td class="px-4 py-3">{{ $weapon->category->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $weapon->country->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $weapon->base_price }}</td>
                                <td class="px-4 py-3">{{ $weapon->manufacturer_price }}</td>
                                <td class="px-4 py-3">{{ $weapon->discount_percentage }}%</td>
                                <td class="px-4 py-3">
                                    @if($weapon->image_path)
                                        <img src="{{ asset('storage/' . $weapon->image_path) }}" alt="Image"
                                            class="h-10 w-10 object-cover rounded" />
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $weapon->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $weapon->is_available ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $weapon->is_featured ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200' }}">
                                        {{ $weapon->is_featured ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('admin.weapons.edit', $weapon) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.weapons.destroy', $weapon) }}" method="POST"
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
