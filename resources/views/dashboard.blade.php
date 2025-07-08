<x-layouts.app :title="__('Dashboard')">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Page Header -->


        <!-- Controls -->
        <div class="flex flex-col md:flex-row justify-between gap-6 mb-8">
            <div class="relative flex-grow max-w-2xl">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Search products..."
                    class="block w-full pl-10 pr-3 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-german-red focus:border-transparent">
            </div>

            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">Tags</flux:button>

                <flux:menu>
                    <flux:menu.item variant="danger" icon="user-group">Infantry</flux:menu.item>
                    <flux:menu.item variant="danger" icon="truck">Tanks</flux:menu.item>
                    <flux:menu.item variant="danger" icon="adjustments-horizontal">Artillery</flux:menu.item>
                    <flux:menu.item variant="danger" icon="paper-airplane">Planes</flux:menu.item>


                </flux:menu>
            </flux:dropdown>
        </div>

        <!-- Product Grid -->
        @livewire('store.card')
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center">
                <a href="#"
                    class="px-3 py-1 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Previous</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="px-4 py-1 border border-gray-300 bg-white text-sm font-medium text-german-red">1</a>
                <a href="#"
                    class="px-4 py-1 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">2</a>
                <a href="#"
                    class="px-4 py-1 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">3</a>
                <span
                    class="px-4 py-1 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-500">...</span>
                <a href="#"
                    class="px-4 py-1 border-t border-b border-r border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">8</a>
                <a href="#"
                    class="px-3 py-1 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>
        </div>
    </div>


    @fluxScripts
</x-layouts.app>
