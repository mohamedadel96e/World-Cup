<x-layouts.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('National Stockpile: ') }} {{ auth()->user()->country->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                @if (session('status'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="mb-6 rounded-md bg-green-100 p-4 transition dark:bg-green-900">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('status') }}</p>
                </div>
                @endif

                {{-- Load the interactive management component --}}
                <livewire:stockpile.manager />

            </div>
        </div>
    </div>
</x-layouts.app>
