<x-layouts.app.header :title="$title ?? null">
    <flux:main>
        @if(session('loggedIn'))
            <audio id="country-audio" src="{{ asset('audio/country-' . auth()->user()->country_id . '.mp3') }}" autoplay hidden volume="0.5"></audio>
        @endif

        {{-- Global Bombing Alert --}}
        @if(isset($unseenBombings) && count($unseenBombings))
            <div class="bg-red-600 text-white p-4 rounded-md shadow-md mb-4 max-w-3xl mx-auto">
                <strong>🚨 Bombing Alert! 🚨</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($unseenBombings as $bombing)
                        <li>
                            {{ $bombing->quantity }}  {{ $bombing->weapon->name }} launched from
                            {{ $bombing->attackerCountry->name }} to your country.
                        </li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ route('bombings.markAsSeen') }}">
                    @csrf
                    <button class="mt-3 bg-white text-red-600 px-4 py-2 rounded hover:bg-gray-100">
                        Mark as seen
                    </button>
                </form>
            </div>
        @endif

        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
