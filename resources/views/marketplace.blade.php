@php
    // The controller now provides $featuredWeapons and a paginated $weapons collection separately.
    $userCountry = auth()->user()->country;
    $userTeam = $userCountry->team;
    $categoryChosen = $categoryChosen ?? null;
    $featuredOnly = isset($featuredOnly) ? $featuredOnly : false;
@endphp

<x-layouts.app :title="__('Marketplace')">
    <div class="mx-auto w-full max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">

        {{-- Hero Section --}}
        <section class="text-center">
            <h1 class="font-bold text-4xl dark:text-white">The Global Marketplace</h1>

            <form action="#" class="mt-6 max-w-xl mx-auto">
                <div class="relative">
                    <input type="search" name="q" placeholder="Search for a specific weapon..." class="w-full rounded-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white pl-12 pr-4 py-3 focus:outline-none focus:ring-0 focus:ring-offset-0 border-2">
                </div>
            </form>
        </section>

        {{-- Category Filters --}}
        @if (!empty($categories))
            <section class="flex flex-wrap justify-center gap-2 ">
                <x-marketplace.tags.tag
                    size="md"
                    :color="!$categoryChosen ? 'primary' : 'link'"
                    :link="route('marketplace')">
                    All
                </x-marketplace.tags.tag>
                @foreach ($categories as $category)
                    <x-marketplace.tags.tag
                        size="md"
                        :color="$categoryChosen && $categoryChosen->is($category) ? 'primary' : 'link'"
                        :link="route('marketplace.category', $category->id)">
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
                <a
                href="{{ route('marketplace') }}"
                class="ml-4 text-sm font-medium text-orange-600 dark:text-orange-400 hover:underline"
                >
                View all featured
                </a>
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
                            No weapons found in this category.
                        </div>
                    @endforelse
                </x-marketplace.weapons.cards-container>
            </div>

        </section>

    </div>

    @fluxScripts
</x-layouts.app>
