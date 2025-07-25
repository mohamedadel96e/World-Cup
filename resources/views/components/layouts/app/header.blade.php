<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('marketplace') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:navbar class="-mb-px max-lg:hidden">
            <!-- <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                {{ __('Home') }}
            </flux:navbar.item>
            <flux:navbar.item icon="clock" :href="route('history')" :current="request()->routeIs('history')" wire:navigate>
                {{ __('History') }}
            </flux:navbar.item> -->
            <flux:navbar.item icon="layout-grid" :href="route('marketplace')"
                :current="request()->routeIs('marketplace')" wire:navigate>
                {{ __('Marketplace') }}
            </flux:navbar.item>
            @if(auth()->user()->role === 'general' || auth()->user()->role === 'country')
            <flux:navbar.item icon="shopping-cart" :href="route('inventory.index')" :current="request()->routeIs('inventory.index')" wire:navigate>
                {{ __('Inventory') }}
            </flux:navbar.item>
            @endif


            @can('create', App\Models\Weapon::class)
            <flux:navbar.item icon="shield-check" :href="route('stockpile.index')"
                :current="request()->routeIs('stockpile.index')" wire:navigate>
                {{ __('Stockpile') }}
            </flux:navbar.item>

            <flux:navbar.item icon="plus" :href="route('weapons.create')"
                :current="request()->routeIs('weapons.create')" wire:navigate>
                {{ __('New Weapon') }}
            </flux:navbar.item>
            @endcan

            @if(auth()->user()->role == 'admin')
            <flux:navbar.item icon="layout-grid" :href="route('admin.dashboard')"
                :current="request()->routeIs('admin.dashboard')" wire:navigate>
                {{ __('Admin Dashboard') }}
            </flux:navbar.item>
            @endif

        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">

            <!-- <flux:tooltip :content="__('Settings')" position="bottom">
                <flux:navbar.item
                    class="h-10 max-lg:hidden [&>div>svg]:size-5"
                    icon="user"
                    :href="route('settings.profile')"
                    :label="__('Settings')" />
            </flux:tooltip> -->
            @if(auth()->user()->role == 'general')
            <flux:navbar.item icon="chevrons-up-down" :href="route('mail.request-csv')"
                :current="request()->routeIs('mail.request-csv')" wire:navigate>
                {{ __('Make a Request') }}
            </flux:navbar.item>
            @endif

            @if(auth()->user()->role == 'country')
            @php
            $inboxCount = App\Models\SupplyRequest::where('status', 'pending')
            ->whereHas('user', function ($query) {
            $query->where('country_id', Auth::user()->country_id);
            })
            ->count();
            @endphp
            <flux:navbar.item icon="inbox" badge="{{ $inboxCount }}" :href="route('inbox')" :current="request()->routeIs('inbox')"
                wire:navigate>
                {{ __('Inbox') }}
            </flux:navbar.item>
            @endif

        </flux:navbar>

        <!-- Desktop User Menu -->
        <flux:dropdown position="top" align="end">

            <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()"
                :avatar="auth()->user()->profile_picture" x-data :circle="true" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            @if(auth()->user()->profile_picture)
                            <img id="profile-picture" src="{{ auth()->user()->profile_picture }}"
                                alt="{{ auth()->user()->name }}"
                                class="h-8 w-8 shrink-0 object-cover rounded-full border border-neutral-400" x-data="{}"
                                x-init="
                                                            window.addEventListener('profile-updated', function(e) {
                                                                if (e.detail && e.detail.profile_picture) {
                                                                    $el.src = e.detail.profile_picture;
                                                                }
                                                            });
                                                        ">
                            @else
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>
                            @endif


                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold" x-data x-init="window.addEventListener('profile-updated', function(e) {
                                        if (e.detail && e.detail.userName) {
                                            $el.textContent = e.detail.userName;
                                        }
                                    });">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs" x-data x-init="window.addEventListener('profile-updated', function(e) {
                                        if (e.detail && e.detail.userEmail) {
                                            $el.textContent = e.detail.userEmail;
                                        }
                                    });">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('marketplace') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                <flux:navlist.item icon="layout-grid" :href="route('marketplace')"
                    :current="request()->routeIs('marketplace')" wire:navigate>
                    {{ __('Marketplace') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
</body>

</html>
