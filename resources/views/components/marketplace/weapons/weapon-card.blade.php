@props([
'weapon' => null,
'countryFlag' => null,
'discount' => 0,
'userCountry' => null,
'buttonText' => 'Buy Now'
])

@php
$title = $weapon->name ?? '';
$description = $weapon->description ?? '';
$image_path = $weapon->image_path ?? '';
$price = $weapon->base_price ?? null;
$discount = $discount > 0 ? $discount : 0;
$newPrice = $price ? $price - ($price * ($discount / 100)) : null;
$category = $weapon->category->name ?? '';
$isFeatured = $weapon->is_featured ?? false;
$countryImage = $countryFlag ?? ($weapon->country?->flag ?? null);
@endphp

<div class="product-card bg-neutral-900 rounded-xl shadow overflow-hidden transition-all duration-300">
    <div class="relative">
        @if ($discount)
        <span class="absolute top-2 left-2 font-[Giorgia] bg-red-500 text-white text-md px-2 py rounded-xl">
            -{{ $discount }}%
        </span>
        @endif
        @if($image_path)
        <img src="{{ $image_path }}" alt="{{ $title }}" class="w-full object-cover">
        @else
        <img src="https://via.placeholder.com/300" alt="{{ $title }}" class="w-full object-cover">
        @endif
        @if ($countryImage)
        <div class="absolute top-2 right-2 w-10 h-10 rounded-full border border-neutral-600">
            <img src="{{ $countryImage }}" alt="Country Flag" class="w-full h-full object-cover rounded-full">
        </div>
        @endif
    </div>

    <div class="p-4 flex flex-col gap-1.5 justify-between">
        <h3 class="text-lg font-semibold text-neutral-100">{{ $title }}</h3>

        @if ($description)
        <p class="text-sm text-neutral-400 mt-1 h-8">
            {{ Str::limit($description, 50) }}
        </p>
        @endif

        <div class="mt-3 flex items-center justify-between">
            <span class="text-lg font-bold text-orange-400"><span class="text-orange-500">{{ $userCountry->currency_symbol }}</span>{{ $newPrice }}</span>

            @if ($price && $discount > 0)
            <span class="text-sm text-neutral-500 line-through">{{ $userCountry->currency_symbol . $price }}</span>
            @endif
        </div>

        <div class="mt-4">
            <x-marketplace.tags.tag color="primary" size="sm" link="#" class="mr-2">
                {{ $category }}
            </x-marketplace.tags.tag>
            @if ($isFeatured)
            <x-marketplace.tags.tag color="success" size="sm" link="#" class="mr-2">
                Featured
            </x-marketplace.tags.tag>
            @endif
        </div>
        <div class="flex-end">
            @can('purchase', $weapon)

            <div class="flex flex-row gap-2 mt-4">
                <a href="{{ route('marketplace.show', $weapon) }}"
                    class=" flex-1 bg-neutral-800 hover:bg-orange-500 text-white py-2 px-4 rounded-lg transition duration-300 hover:cursor-pointer text-center">
                    {{ $buttonText }}
                </a>
                @can('update', $weapon)

                <a href="{{ route('marketplace.edit', $weapon) }}" class=" flex-1 bg-neutral-700 hover:bg-blue-800 text-white py-2 px-4 rounded-lg transition duration-300 font-main hover:cursor-pointer text-center">
                    Edit
                </a>

                @endcan
            </div>
            @else
            <div class="flex flex-row gap-2 mt-4">
                <span class="flex-1 bg-neutral-800 text-white py-2 px-4 rounded-lg transition duration-300 text-center">
                    {{ __('Not available for purchase') }}
                </span>
            </div>
            @endcan
        </div>
    </div>
</div>
