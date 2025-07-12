<?php

use App\Models\Category;
use App\Models\Weapon;
use App\Services\CurrencyConversionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use Livewire\WithPagination;

// Use a full-page layout and import the pagination trait
new #[Layout('components.layouts.app')] class extends Component {
    use WithPagination;

    // This property will be updated in real-time from the search input.
    // The `Url` attribute keeps the search term in the browser's query string.
    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public ?int $category_id = null;

    public function filterByCategory(?int $categoryId): void
    {
        $this->category_id = $categoryId;
        // Reset pagination when the category changes
        $this->resetPage();
    }

    // This method passes all the necessary data to the view.
    public function with(CurrencyConversionService $currencyService): array
    {
        $userCountry = Auth::user()->country;
        $userTeam = $userCountry->team;

        // The main weapon query, now with real-time search and category filtering
        $weaponQuery = Weapon::with('category', 'country')
            ->where('is_featured', false)
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id));

        // foreach ($weaponQuery->get() as $weapon) {
        //     $weapon->base_price = $currencyService->convert($weapon->base_price, $weapon->country->currency_code, $userCountry->currency_code);
        // }

        // The featured weapons query also includes search AND the category filter
        $featuredQuery = Weapon::with('category', 'country')
            ->where('is_featured', true)
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id)); // <-- FIX: Added category filter here

        // foreach ($featuredQuery->get() as $weapon) {
        //     $weapon->base_price = $currencyService->convert($weapon->base_price, $weapon->country->currency_code, $userCountry->currency_code);
        // }

        return [
            'featuredWeapons' => $featuredQuery->orderByDesc('created_at')->get(),
            'weapons' => $weaponQuery->orderByDesc('created_at')->paginate(12),
            'categories' => Category::all(),
            'userCountry' => $userCountry,
            'userTeam' => $userTeam,
        ];
    }
}; ?>

<div>
    <x-slot name="title">{{ __('Marketplace') }}</x-slot>

    <div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-2 sm:px-6 lg:px-8">

        {{-- Hero Section --}}
        <section class="text-center">
            <h1 class="font-bold text-4xl dark:text-white">The Global Marketplace</h1>

            {{-- Real-time Search Form --}}
            <div class="mt-6 max-w-xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    </div>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search for a specific weapon..."
                        class="w-full border-2 rounded-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white pl-12 pr-4 py-3 focus:outline-none focus:ring-0 focus:ring-offset-0"
                    >
                </div>
            </div>
        </section>

        {{-- Category Filters --}}
        @if ($categories->isNotEmpty())
            <section class="flex flex-wrap justify-center gap-2">
                <x-marketplace.tags.tag
                    wire:click="filterByCategory(null)"
                    size="md"
                    :color="!$category_id ? 'primary' : 'secondary'"
                    class="cursor-pointer"
                >
                    All
                </x-marketplace.tags.tag>
                @foreach ($categories as $category)
                    <x-marketplace.tags.tag
                        wire:click="filterByCategory({{ $category->id }})"
                        size="md"
                        :color="$category_id === $category->id ? 'primary' : 'secondary'"
                        class="cursor-pointer"
                    >
                        {{ $category->name }}
                    </x-marketplace.tags.tag>
                @endforeach
            </section>
        @endif

        {{-- Featured Weapons Section --}}
        @if ($featuredWeapons->isNotEmpty())
            <section>
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-orange-600 dark:text-orange-400">Featured Weapons</h2>
                    <div class="h-0.5 bg-orange-600 flex-grow ml-4 opacity-60"></div>
                </div>
                <div class="mt-6">
                    <x-marketplace.weapons.cards-container>
                        @foreach ($featuredWeapons as $weapon)
                            <x-marketplace.weapons.weapon-card
                                :weapon="$weapon"
                                :countryFlag="$weapon->country->flag"
                                :userCountry="$userCountry"
                                :discount="$userTeam->is($weapon->country->team) ? $weapon->discount_percentage : 0"
                                class="ring-2 ring-orange-400 shadow-xl"
                            />
                        @endforeach
                    </x-marketplace.weapons.cards-container>
                </div>
            </section>
        @endif

        {{-- All Weapons Section --}}
        <section>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-100">General Marketplace</h2>
                <div class="h-px bg-zinc-300 dark:bg-zinc-700 flex-grow ml-4"></div>
            </div>
            <div class="mt-6">
                <x-marketplace.weapons.cards-container>
                    @forelse ($weapons as $weapon)
                        <x-marketplace.weapons.weapon-card
                            :weapon="$weapon"
                            :countryFlag="$weapon->country->flag"
                            :userCountry="$userCountry"
                            :discount="$userTeam->is($weapon->country->team) ? $weapon->discount_percentage : 0"
                            buttonText="Buy Now" />
                    @empty
                        <div class="col-span-full text-center text-zinc-500 dark:text-zinc-400 py-16">
                            <p class="text-lg">No weapons found matching your criteria.</p>
                        </div>
                    @endforelse
                </x-marketplace.weapons.cards-container>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-10">
                {{ $weapons->links('vendor.pagination.tailwind', ['wire:navigate' => true]) }}
            </div>
        </section>

    </div>
</div>
