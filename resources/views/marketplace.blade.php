@php
    $userCountry = auth()->user()->country;
    $userTeam = $userCountry->team;
@endphp
<x-layouts.app :title="__('Marketplace')">
    <div class="max-w-10xl w-full mx-auto px-4 py-8 flex gap-8">
        <x-marketplace.weapons.cards-container>
            @foreach ($weapons as $weapon)
                <x-marketplace.weapons.weapon-card :weapon="$weapon" :countryFlag="$weapon->country->flag"
                    :userCountry="$userCountry" :discount="$userTeam->is($weapon->country->team) ? $weapon->discount_percentage : 0" buttonText="Buy Now" />
            @endforeach
        </x-marketplace.weapons.cards-container>

        @if (!empty($categories))
            <x-marketplace.tags.tags-container class="flex-end">
                @foreach ($categories as $category)
                    <x-marketplace.tags.tag size="sm" :link="route('home', ['category' => $category])">

                        {{ $category->name }}

                    </x-marketplace.tags.tag>
                @endforeach
            </x-marketplace.tags.tags-container>
        @endif
        <flux:button href="weapons/csv/download" icon="arrow-down-tray">Export</flux:button>


    </div>

    @fluxScripts
</x-layouts.app>