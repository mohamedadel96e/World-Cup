<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

    <div class="product-card bg-gray-900 rounded-xl shadow overflow-hidden transition-all duration-300">
        <div class="relative">
            <img src="https://media.gettyimages.com/id/638319418/photo/view-of-a-german-panzer-iv-medium-tank-1940s-it-mounted-a-short-75mm-gun.jpg?s=612x612&w=0&k=20&c=w9rscd2JV0tRHSYwZCVpvtSM5X5VOBVQRM0OIT815hU="
                alt="tank" class="w-full h-60 object-cover">

        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-orange-400">Panzer IV</h3>
            <p class="text-sm text-gray-500 mt-1">1/32 Scale</p>

            <div class="mt-3 flex items-center justify-between">
                <span class="text-lg font-bold text-german-red">€189.99</span>
                <span class="text-sm text-gray-500 line-through">€229.99</span>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">Tank</span>
            </div>

            <button
                class="mt-4 w-full bg-german-black hover:bg-german-red text-white py-2 px-4 rounded-lg transition duration-300">
                Buy
            </button>
        </div>
    </div>
</div>
