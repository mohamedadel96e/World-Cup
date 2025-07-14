<div>
    <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Search Bar -->
        <div class="relative w-full sm:w-1/3">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Search your stockpile..."
                class="w-full rounded-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white pl-10 pr-4 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
            >
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2">
            <button wire:click="exportCsv" class="inline-flex items-center gap-2 rounded-md bg-zinc-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-zinc-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v4.59L7.3 9.24a.75.75 0 0 0-1.1 1.02l3.25 3.5a.75.75 0 0 0 1.1 0l3.25-3.5a.75.75 0 0 0-1.1-1.02l-1.95 2.1V6.75Z" clip-rule="evenodd" /></svg>
                Export Report
            </button>
            <a href="{{ route('weapons.create') }}" class="inline-flex items-center gap-2 rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" /></svg>
                Add Weapon
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Weapon</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Quantity</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                @forelse ($weapons as $weapon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $weapon->image_path }}" alt="{{ $weapon->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $weapon->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-marketplace.tags.tag color="secondary">{{ $weapon->category->name }}</x-marketplace.tags.tag>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-300">
                            {{ number_format($weapon->base_price, 2) }} {{ $weapon->country->currency_code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-zinc-900 dark:text-white">{{ $weapon->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('weapons.edit', $weapon) }}" class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-300">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500">
                            No weapons found in your stockpile.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $weapons->links('vendor.pagination.tailwind') }}
    </div>
</div>
