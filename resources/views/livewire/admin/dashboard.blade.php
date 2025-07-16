<x-layouts.app :title="__('Admin Dashboard')">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            High Command
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-zinc-900 dark:text-zinc-100 mb-2">Admin Dashboard</h1>
                <p class="text-lg text-zinc-600 dark:text-zinc-400">Welcome, Kommandant! Manage all system entities from this central hub.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Users Card -->
                <a href="{{ route('admin.users.index') }}" class="group block rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-center gap-4">
                        <div class="rounded-lg bg-orange-100 p-3 dark:bg-orange-900/50">
                            <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.253a9.527 9.527 0 0 0-1.249-1.513M12 12h3.75M12 15h3.75M12 18h3.75M7.5 12h-.75a.75.75 0 0 0-.75.75v4.5a.75.75 0 0 0 .75.75h4.5a.75.75 0 0 0 .75-.75v-4.5a.75.75 0 0 0-.75-.75h-.75M7.5 12V7.5a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v4.5" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Users</h3>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Manage all personnel, roles, and country assignments.</p>
                </a>

                <!-- Weapons Card -->
                <a href="{{ route('admin.weapons.index') }}" class="group block rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-center gap-4">
                        <div class="rounded-lg bg-orange-100 p-3 dark:bg-orange-900/50">
                             <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V5.25A2.25 2.25 0 0 0 18 3H6A2.25 2.25 0 0 0 3.75 5.25v12.75A2.25 2.25 0 0 0 6 20.25Z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Weapons</h3>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Manage all master weapon blueprints and attributes.</p>
                </a>

                <!-- Categories Card -->
                <a href="{{ route('admin.categories.index') }}" class="group block rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-center gap-4">
                        <div class="rounded-lg bg-orange-100 p-3 dark:bg-orange-900/50">
                            <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Categories</h3>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Organize weapons into distinct categories.</p>
                </a>

                <!-- Countries Card -->
                <a href="{{ route('admin.countries.index') }}" class="group block rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-center gap-4">
                        <div class="rounded-lg bg-orange-100 p-3 dark:bg-orange-900/50">
                            <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21v-4.5m0 4.5h16.5M3.75 21V8.25m0 12.75c-1.33-2.016-2.25-4.514-2.25-7.125C1.5 9.364 4.864 6 9 6c4.136 0 7.5 3.364 7.5 7.5 0 2.611-.92 5.109-2.25 7.125m-11.25 0c1.33-2.016 2.25-4.514 2.25-7.125m-2.25 7.125a2.25 2.25 0 0 1-2.25-2.25v-6.75a2.25 2.25 0 0 1 2.25-2.25h16.5a2.25 2.25 0 0 1 2.25 2.25v6.75a2.25 2.25 0 0 1-2.25 2.25m-16.5-7.5h16.5" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Countries</h3>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Manage all national entities and their attributes.</p>
                </a>

                <!-- Teams Card -->
                <a href="{{ route('admin.teams.index') }}" class="group block rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="flex items-center gap-4">
                        <div class="rounded-lg bg-orange-100 p-3 dark:bg-orange-900/50">
                            <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.962a3.752 3.752 0 0 1-4.131 0m-3.75 3.75a3.752 3.752 0 0 1-4.131 0m6.531 2.962a3.752 3.752 0 0 1-4.131 0M12 3v1.5m0 15V21m0-9.75a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Zm0 9.75a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Teams</h3>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Manage the Axis and Allies team alliances.</p>
                </a>

            </div>
        </div>
    </div>
</x-layouts.app>
