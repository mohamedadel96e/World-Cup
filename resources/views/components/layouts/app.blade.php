<x-layouts.app.header :title="$title ?? null">
    @if(session('loggedIn'))
        <!-- Session('loggedIn') | -->
        <!-- Session('loggedIn') -->
        <audio id="country-audio" src="{{ asset('audio/country-' . auth()->user()->country_id . '.mp3') }}" autoplay hidden></audio>
    <audio id="country-audio" src="{{ asset('audio/country-' . auth()->user()->country_id . '.mp3') }}" autoplay hidden></audio>
    @endif
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
