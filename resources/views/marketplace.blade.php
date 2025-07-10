@php
    $userTeam = auth()->user()->country->team;
@endphp
<x-layouts.app :title="__('Marketplace')">
    <div class="max-w-10xl w-full mx-auto px-4 py-8 flex gap-8">
        <x-marketplace.cards-container>
            @foreach ($weapons as $weapon)
            <x-marketplace.weapon-card
                :weapon="$weapon"
                :countryFlag="$weapon->country->flag"
                :discount="$userTeam->is($weapon->country->team) ? $weapon->discount_percentage : 0"
                buttonText="Buy Now" />
            @endforeach
        </x-marketplace.cards-container>

        @if (!empty($categories))
        <x-marketplace.tags-container class="flex-end">
            @foreach ($categories as $category)
            <x-marketplace.tag size="sm" :link="route('home', ['category' => $category])">

            {{ $category->name }}

            </x-marketplace.tag>
            @endforeach
        </x-marketplace.tags-container>
        @endif

    </div>

    @fluxScripts
</x-layouts.app>
