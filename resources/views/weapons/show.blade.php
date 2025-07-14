@php
    $discount = $weapon->discount_percentage ?? 0;
    $user = auth()->user();
    $currencySymbol = $user?->country?->currency_symbol ?? '$';
@endphp

<x-layouts.app :title="__('Weapon Details')">
    <div class="max-w-5xl mx-auto py-10 px-6 text-white">
        @if (session()->has('success'))
            <div class="bg-green-600 text-white px-4 py-2 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6 bg-neutral-900 p-6 rounded-xl shadow">
            <div class="relative">
                @if ($weapon->image_path)
                    <img src="{{ $weapon->image_path }}" alt="{{ $weapon->name }}" class="rounded-lg shadow w-full">
                @else
                    <img src="https://via.placeholder.com/400" class="rounded-lg shadow w-full">
                @endif

                @if ($weapon->country?->flag)
                    <div class="absolute top-4 right-4 w-12 h-12 rounded-full overflow-hidden border-2 border-neutral-700">
                        <img src="{{ $weapon->country->flag }}" alt="Country Flag" class="w-full h-full object-cover">
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="flex flex-col justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">{{ $weapon->name }}</h2>
                    @if ($weapon->description)
                        <p class="text-neutral-400 mb-4">{{ $weapon->description }}</p>
                    @endif

                    <div class="flex items-center gap-4 mb-4">
                        @php
                            $price = $weapon->base_price;

                            $newPrice = $price - ($price * ($discount / 100));
                            $currency = auth()->user()?->country?->currency_symbol ?? '$';
                        @endphp

                        @if ($discount > 0)
                            <span class="text-lg font-bold text-orange-400"><span class="text-orange-500">{{ $currency }}</span>{{ $newPrice }}</span>
                            <span class="text-red-500 font-semibold">-{{ $discount }}%</span>
                        @endif
                    </div>

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
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 px-6 py-2 rounded text-white text-lg w-full hover:cursor-pointer">
                                {{ __('Buy Now') }}
                            </button>
                        </form>
                        @if ($errors->has('error'))
                            <div class=" text-red-400 px-4 py-2 rounded mt-4">
                                {{ $errors->first('error') }}
                            </div>
                        @endif
                    @else
                        <div class="bg-neutral-800 text-center px-6 py-2 rounded text-white text-lg">
                            {{ __('Not available for purchase') }}
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
