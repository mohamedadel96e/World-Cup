<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="rounded-2xl border border-blue-100 p-4 w-72 shadow-md relative bg-white">
    <!-- ID -->
    <p class="text-xs text-right text-gray-400 absolute top-2 right-3">id: 12345689</p>

    <!-- Product Image -->
    <div class="relative flex justify-center">
        <img src="https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-model-unselect-gallery-1-202309?wid=512&hei=512&fmt=jpeg&qlt=90&.v=1692916240076" alt="iPhone" class="h-40 object-contain" />

        <!-- Icons -->
        <div class="absolute right-3 top-3 space-y-2">
            <div class="bg-blue-100 p-1 rounded-full">
                <x-icon name="scale" class="text-blue-600 w-4 h-4" />
            </div>
            <div class="bg-gray-100 p-1 rounded-full">
                <x-icon name="heart" class="text-gray-500 w-4 h-4" />
            </div>
        </div>
    </div>

    <!-- Title -->
    <h3 class="mt-4 text-sm font-semibold text-gray-800">Apple iPhone 15 Pro</h3>

    <!-- Rating -->
    <div class="flex items-center gap-1 text-sm text-yellow-400 mt-1">
        @for ($i = 0; $i < 5; $i++)
            <x-icon name="star" class="w-4 h-4" />
        @endfor
        <span class="text-gray-500 text-xs ml-1">97</span>
    </div>

    <!-- Price -->
    <div class="mt-4 flex items-end justify-between">
        <div>
            <div class="text-sm text-gray-400 line-through">$999.00</div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-blue-600 bg-blue-50 px-1 py-0.5 rounded">-10%</span>
                <span class="text-xl font-bold text-gray-800">$899.00</span>
            </div>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-xl">
            <x-icon name="shopping-cart" class="w-5 h-5" />
        </button>
    </div>
</div>
