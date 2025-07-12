@props([
    'weapon' => null,
    'countryFlag' => null,
    'discount' => 0,
    'userCountry' => null,
    'buttonText' => 'Buy Now',
    'imageHeight' => 'h-70',
    'manageImage' => false,
    'tagParameters' => [],
])

@php
    $title = $weapon->name ?? '';
    $description = $weapon->description ?? '';
    $image_path = $weapon->image_path ?? '';
    $price = $weapon->base_price ?? null;
    $discount = $discount > 0 ? $discount : 0;
    $newPrice = $price ? $price - ($price * ($discount / 100)) : null;
    $isFeatured = $weapon->is_featured ?? false;
    $countryImage = $countryFlag ?? ($weapon->country?->flag ?? null);
@endphp

<div class="product-card bg-neutral-900 rounded-xl shadow overflow-hidden flex flex-col transition-all duration-300 h-full">
    <div class="relative">
        @if ($discount)
            <span class="absolute top-2 left-2 font-[Giorgia] bg-red-500 text-white text-md px-2 py rounded-xl">
                -{{ $discount }}%
            </span>
        @endif

        @if($image_path)
            <img src="{{ $image_path }}" alt="{{ $title }}" class="w-full min-h-[274px] max-h-80 object-cover">
        @else
            <div class="w-full min-h-40 max-h-90 flex items-center justify-center">
                <span class="text-7xl font-semibold text-zinc-600 dark:text-zinc-400">
                    {{ Str::upper(Str::substr($title, 0, 2)) }}
                </span>
            </div>
        @endif

        @if ($countryImage)
            <div class="absolute top-2 right-2 w-10 h-10 rounded-full border border-neutral-600">
                <img src="{{ $countryImage }}" alt="Country Flag" class="w-full h-full object-cover rounded-full">
            </div>
        @endif
    </div>

    {{-- Card Body --}}
    <div class="p-4 flex flex-col justify-between flex-grow gap-3">

        <div class="space-y-1">
            <h3 class="text-lg font-semibold text-neutral-100">{{ $title }}</h3>

            @if ($description)
                <p class="text-sm text-neutral-400 h-12 overflow-hidden">{{ Str::limit($description, 60) }}</p>
            @endif

            <div class="mt-1 flex items-center justify-between">
                <span class="text-lg font-bold text-orange-400">
                    <span class="text-orange-500">{{ auth()->user()->country->currency_symbol }}</span>{{ $newPrice }}
                </span>
                @if ($price && $discount > 0)
                    <span class="text-sm text-neutral-500 line-through">{{ auth()->user()->country->currency_symbol . $price }}</span>
                @endif
            </div>

            <div class="mt-2 flex flex-wrap gap-2">
                @if (!empty($weapon->category))
                    <x-marketplace.tags.tag color="secondary" size="sm">
                        {{ $weapon->category->name }}
                    </x-marketplace.tags.tag>
                @endif
                @if ($isFeatured)
                    <x-marketplace.tags.tag color="success" size="sm">
                        Featured
                    </x-marketplace.tags.tag>
                @endif
            </div>
        </div>

        {{-- Bottom Buttons --}}
        <div class="mt-auto pt-4">
            @if ($manageImage)
                <div class="w-full bg-neutral-800 hover:bg-orange-500 text-white py-2 px-4 rounded-lg transition duration-300 text-center hover:cursor-pointer">
                    {{ $buttonText }}
                </div>
            @else
                @can('purchase', $weapon)
                    <div class="flex flex-row gap-2">
                        <a href="{{ route('marketplace.show', $weapon) }}"
                           class="flex-1 bg-neutral-800 hover:bg-orange-500 text-white py-2 px-4 rounded-lg transition duration-300 text-center">
                            {{ $buttonText }}
                        </a>
                        @can('update', $weapon)
                            <a href="{{ route('weapons.edit', $weapon) }}"
                               class="flex-1 bg-neutral-700 hover:bg-blue-800 text-white py-2 px-4 rounded-lg transition duration-300 text-center flex justify-center items-center">
                                Edit
                            </a>
                        @endcan
                    </div>
                @else
                    <div class="w-full bg-neutral-800 text-white py-2 px-4 rounded-lg transition duration-300 text-center">
                        {{ __('Not available for purchase') }}
                    </div>
                @endcan
            @endif
        </div>
    </div>
</div>
