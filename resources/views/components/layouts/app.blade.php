<x-layouts.app.header :title="$title ?? null">
    <flux:main>
        @if(session('loggedIn'))
        <audio id="country-audio" src="{{ asset('audio/country-' . auth()->user()->country_id . '.mp3') }}" autoplay hidden></audio>
        @endif
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
