<x-layouts.app>
    <div class="py-10 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-zinc-900 dark:text-zinc-100 mb-2">Admin Dashboard</h1>
                <p class="text-lg text-zinc-600 dark:text-zinc-300">Welcome, Admin! Manage your data entries below.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow hover:shadow-lg transition-shadow flex flex-col items-center justify-center group cursor-pointer">
                    <span
                        class="text-2xl font-bold mb-2 text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600">Users</span>
                    <span class="text-zinc-500 mb-4">Manage users in the system</span>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-full">Go to Users</a>
                </div>
                <div
                    class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow hover:shadow-lg transition-shadow flex flex-col items-center justify-center group cursor-pointer">
                    <span
                        class="text-2xl font-bold mb-2 text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600">Weapons</span>
                    <span class="text-zinc-500 mb-4">Manage weapons inventory</span>
                    <a href="{{ route('admin.weapons.index') }}" class="btn btn-primary w-full">Go to Weapons</a>
                </div>
                <div
                    class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow hover:shadow-lg transition-shadow flex flex-col items-center justify-center group cursor-pointer">
                    <span
                        class="text-2xl font-bold mb-2 text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600">Countries</span>
                    <span class="text-zinc-500 mb-4">Manage countries data</span>
                    <a href="{{ route('admin.countries.index') }}" class="btn btn-primary w-full">Go to Countries</a>
                </div>
                <div
                    class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow hover:shadow-lg transition-shadow flex flex-col items-center justify-center group cursor-pointer">
                    <span
                        class="text-2xl font-bold mb-2 text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600">Teams</span>
                    <span class="text-zinc-500 mb-4">Manage teams in the system</span>
                    <a href="{{ route('admin.teams.index') }}" class="btn btn-primary w-full">Go to Teams</a>
                </div>
                <div
                    class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow hover:shadow-lg transition-shadow flex flex-col items-center justify-center group cursor-pointer">
                    <span
                        class="text-2xl font-bold mb-2 text-zinc-900 dark:text-zinc-100 group-hover:text-blue-600">Categories</span>
                    <span class="text-zinc-500 mb-4">Manage categories in the system</span>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-full">Go to Categories</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
