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

    // This method now injects the service and prepares all the data for the view.
    public function with(CurrencyConversionService $currencyService): array
    {
        $userCountry = Auth::user()->country;
        $userTeam = $userCountry->team;

        // --- Define Queries ---
        $weaponQuery = Weapon::with('category', 'country')
            ->where('is_featured', false)
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id));

        $featuredQuery = Weapon::with('category', 'country')
            ->where('is_featured', true)
            ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id));

        // --- Fetch Data ---
        $featuredWeapons = $featuredQuery->orderByDesc('created_at')->get();
        $weapons = $weaponQuery->orderByDesc('created_at')->paginate(12);

        // --- Helper function to perform currency conversion ---
        $addConvertedPrice = function ($weapon) use ($currencyService, $userCountry) {
            // Add a new 'display_price' attribute to the weapon model in memory
            $weapon->display_price = $currencyService->convert(
                amount: $weapon->base_price,
                fromCurrency: $weapon->country->currency_code,
                toCurrency: $userCountry->currency_code
            );
            return $weapon;
        };

        // --- Apply the conversion to the fetched collections ---
        $featuredWeapons->each($addConvertedPrice);
        $weapons->getCollection()->transform($addConvertedPrice);

        // --- Return the MODIFIED data to the view ---
        return [
            'featuredWeapons' => $featuredWeapons,
            'weapons' => $weapons,
            'categories' => Category::all(),
            'userCountry' => $userCountry,
            'userTeam' => $userTeam,
        ];
    }
}; ?>

<div>
    <x-slot name="title">{{ __('Marketplace') }}</x-slot>

    <div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-2 sm:px-6 lg:px-8">

        @if (session('status'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="rounded-md bg-green-100 p-4 dark:bg-green-900">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400 dark:text-green-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('status') }}</p>
                </div>
            </div>
        </div>
        @endif


        @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="rounded-md bg-green-100 p-4 dark:bg-green-900">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400 dark:text-green-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Hero Section --}}
        <section class="text-center">
            <h1 class="font-bold text-4xl dark:text-white">The Global Marketplace</h1>

            {{-- Real-time Search Form --}}
            <div class="mt-6 max-w-xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search for a specific weapon..."
                        class="w-full border-2 rounded-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white pl-12 pr-4 py-3 focus:outline-none focus:ring-0 focus:ring-offset-0">
                </div>
            </div>
        </section>

        <section class="flex justify-center">
            <div class="inline-flex items-center gap-4 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 px-6 py-3 shadow-sm">
                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">National Treasury:</span>
                <span class="text-xl font-bold text-green-600 dark:text-green-400">
                    {{ $userCountry->currency_symbol }}{{ number_format($userCountry->balance, 2) }}
                </span>
            </div>

            <div class="inline-flex items-center gap-4 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 px-6 py-3 shadow-sm">
                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Your Balance:</span>
                <span class="text-xl font-bold text-green-600 dark:text-green-400">
                    {{ $userCountry->currency_symbol }}{{ number_format(auth()->user()->balance, 2) }}
                </span>
            </div>
        </section>

        {{-- Category Filters --}}
        @if ($categories->isNotEmpty())
        <section class="flex flex-wrap justify-center gap-2">
            <x-marketplace.tags.tag
                wire:click="filterByCategory(null)"
                size="md"
                :color="!$category_id ? 'primary' : 'secondary'"
                class="cursor-pointer">
                All
            </x-marketplace.tags.tag>
            @foreach ($categories as $category)
            <x-marketplace.tags.tag
                wire:click="filterByCategory({{ $category->id }})"
                size="md"
                :color="$category_id === $category->id ? 'primary' : 'secondary'"
                class="cursor-pointer">
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
                        class="ring-2 ring-orange-400 shadow-xl" />
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
                {{ $weapons->links('vendor.pagination.tailwind') }}
            </div>
        </section>

    </div>
</div>
