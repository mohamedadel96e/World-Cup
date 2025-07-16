<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Countries</h2>
                <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">Add Country</a>
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
                                Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Team</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Currency Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Currency Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Currency Symbol</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Balance</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Logo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Flag</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($countries as $country)
                            <tr
                                class="hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors {{ $loop->even ? 'bg-zinc-50 dark:bg-zinc-900' : 'bg-white dark:bg-zinc-800' }}">
                                <td class="px-4 py-3">{{ $country->id }}</td>
                                <td class="px-4 py-3 font-medium">{{ $country->name }}</td>
                                <td class="px-4 py-3">{{ $country->code }}</td>
                                <td class="px-4 py-3">{{ $country->team->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $country->currency_name }}</td>
                                <td class="px-4 py-3">{{ $country->currency_code }}</td>
                                <td class="px-4 py-3">{{ $country->currency_symbol }}</td>
                                <td class="px-4 py-3">{{ number_format($country->balance) }}</td>
                                <td class="px-4 py-3">
                                    @if($country->logo)
                                        <img src="{{ asset('storage/' . $country->logo) }}" alt="Logo"
                                            class="h-8 w-8 object-cover rounded" />
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($country->flag)
                                        <img src="{{ asset('storage/' . $country->flag) }}" alt="Flag"
                                            class="h-8 w-8 object-cover rounded" />
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('admin.countries.edit', $country) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.countries.destroy', $country) }}" method="POST"
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
