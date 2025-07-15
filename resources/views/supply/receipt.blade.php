<x-layouts.app :title="__('Supply Requisition Receipt')">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Requisition Receipt: #{{ str_pad($supplyRequest->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-8 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="mb-6 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Requisition Details</h3>
                        <p class="text-sm text-gray-500">Submitted by: {{ $supplyRequest->user->name }}</p>
                        <p class="text-sm text-gray-500">Date: {{ $supplyRequest->created_at->format('F j, Y, g:i a') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold
                            @if($supplyRequest->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif">
                            {{ ucfirst($supplyRequest->status) }}
                        </span>
                    </div>
                </div>

                <div class="flow-root">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Weapon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Qty Requested</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
                            @foreach($supplyRequest->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->weapon->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->quantity_requested }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                        @if($item->status === 'Provided') <span class="text-green-600 dark:text-green-400">{{ $item->status }}</span>
                                        @elseif($item->status === 'Purchase Required') <span class="text-yellow-600 dark:text-yellow-400">{{ $item->status }}</span>
                                        @else <span class="text-red-600 dark:text-red-400">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('marketplace') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500 dark:text-orange-400 dark:hover:text-orange-300">
                        &larr; Go to marketplace
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
