@php
    // All necessary data is now passed directly from the controller.
    // $weapon->display_price is the base price already converted to the user's currency.
    $priceInUserCurrency = $weapon->display_price ?? 0;
    $finalPrice = $priceInUserCurrency - ($priceInUserCurrency * ($discount / 100));
@endphp

<x-layouts.app :title="$weapon->name">
    <div class="max-w-5xl mx-auto py-10 px-6 text-white">
        @if (session()->has('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('error'))
            <div class="bg-red-600 text-white px-4 py-2 rounded mb-6">
                {{ $errors->first('error') }}
            </div>
        @endif


        <div class="grid md:grid-cols-2 gap-8 bg-neutral-900 p-6 rounded-xl shadow">
            <!-- Image Column -->
            <div class="relative">
                @if ($weapon->image_path)
                    <img src="{{ $weapon->image_path }}" alt="{{ $weapon->name }}" class="rounded-lg shadow w-full">
                @else
                    <img src="https://via.placeholder.com/600x400/2d3748/ffffff?text=Image+Not+Available" class="rounded-lg shadow w-full">
                @endif

                @if ($weapon->country?->flag)
                    <div class="absolute top-4 right-4 w-12 h-12 rounded-full overflow-hidden border-2 border-neutral-700">
                        <img src="{{ $weapon->country->flag }}" alt="Country Flag" class="w-full h-full object-cover">
                    </div>
                @endif
            </div>

            <!-- Details & Actions Column -->
            <div class="flex flex-col justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">{{ $weapon->name }}</h2>
                    @if ($weapon->description)
                        <p class="text-neutral-400 mb-4">{{ $weapon->description }}</p>
                    @endif

                    <!-- Price Display -->
                    <div class="flex items-baseline gap-4 mb-4">
                        <span class="text-4xl font-bold text-orange-400">
                            {{ $userCountry->currency_symbol }}{{ number_format($finalPrice, 2) }}
                        </span>
                        @if ($discount > 0)
                            <span class="text-xl text-neutral-500 line-through">
                                {{ $userCountry->currency_symbol }}{{ number_format($priceInUserCurrency, 2) }}
                            </span>
                            <span class="text-lg font-semibold text-red-500">-{{ $discount }}%</span>
                        @endif
                    </div>

                    <!-- Tags -->
                    <div class="flex items-center gap-2">
                        <x-marketplace.tags.tag color="primary" size="sm">
                            {{ $weapon->category->name ?? 'Uncategorized' }}
                        </x-marketplace.tags.tag>

                        @if ($weapon->is_featured)
                            <x-marketplace.tags.tag color="success" size="sm">
                                Featured
                            </x-marketplace.tags.tag>
                        @endif
                    </div>
                </div>

                <!-- Purchase Button -->
                <div class="mt-8">
                    @can('purchase', $weapon)
                        <form action="{{ route('weapons.purchase') }}" method="POST">
                            @csrf
                            <input type="hidden" name="weapon_id" value="{{ $weapon->id }}">
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 px-6 py-3 rounded text-white text-lg w-full font-semibold shadow-lg transition-transform hover:scale-105">
                                {{ __('Acquire Weapon') }}
                            </button>
                        </form>
                    @else
                        <div class="bg-neutral-800 text-center px-6 py-3 rounded text-white text-lg font-semibold">
                            {{ __('Not available for purchase') }}
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
