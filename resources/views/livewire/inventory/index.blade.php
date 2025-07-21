<?php

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('components.layouts.app', ['title' => 'Inventory'])] class extends Component {
    use WithPagination;

    public string $search = '';
    public Country $userCountry;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $user = Auth::user();
        $this->userCountry = $user->country;
        // This query starts from the user and fetches all their weapons
        // through the user_weapon pivot table.
        $weaponsQuery = $user->weapons()
            ->with(['category', 'country']) // Eager load relationships
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('user_weapon.updated_at'); // Order by most recently acquired


        return [
            'weapons' => $weaponsQuery->paginate(10),
            'countries' => Country::where('id', '!=', $this->userCountry->id)
                ->orderBy('name')
                ->get(),
        ];
    }
};
?>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Personal Inventory: ') }} {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white p-6 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Search Bar -->
                    <div class="relative w-full sm:w-1/3">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <input
                            type="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search your inventory..."
                            class="w-full rounded-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white pl-10 pr-4 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>

                <!-- Data Table -->
                <div class="min-w-full overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Weapon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Manufacturer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Last Acquisition Note</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-300">Use It! 💥</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                            @forelse ($weapons as $weapon)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $weapon->image_path }}" alt="{{ $weapon->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $weapon->name }}</div>
                                            <div class="text-xs text-zinc-500">{{ $weapon->category->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $weapon->country->flag }}" alt="{{ $weapon->country->name }}" class="h-6 w-6 rounded-full object-cover mr-2">
                                        <span class="text-sm text-zinc-500 dark:text-zinc-300">{{ $weapon->country->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-zinc-900 dark:text-white">{{ $weapon->pivot->quantity ?? "One Weapon" }}</td>
                                <td class="px-6 py-4 whitespace-wrap text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $weapon->pivot->note ?? "You purchased it with cost of " . ($weapon->pivot->price_paid ?? "Unknown") . " " . ($userCountry->currency_code ?? "") }}
                                </td>
                                <td class="px-6 py-4 whitespace-wrap">
                                    <div x-data="{ open: false, quantity: {{ $weapon->pivot->quantity ?? 0 }} }" class="relative">
                                        <!-- Send Button -->
                                        <button
                                            @click="if(quantity > 0) open = !open"
                                            :disabled="quantity === 0"
                                            :class="quantity === 0
                                                    ? 'px-6 py-4 bg-gray-500 cursor-not-allowed text-zinc-700'
                                                    : 'px-6 py-4 whitespace-nowrap text-sm border rounded-md text-zinc-200 transition-colors hover:bg-red-600 hover:text-black'">
                                            BOMB
                                        </button>

                                        <!-- Form -->
                                        <form
                                            x-show="open"
                                            x-transition
                                            method="POST"
                                            action="{{ route('weapons.bomb', $weapon->id) }}"
                                            class="mt-4 p-4 border rounded-md bg-black shadow-md space-y-4 w-full max-w-sm">
                                            @csrf


                                            <input type="hidden" name="weapon_id" value="{{ $weapon->id }}">
                                            <!-- Quantity Input -->
                                                <div>
                                                    <label class="block text-sm font-medium text-zinc-200">Quantity</label>
                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        min="1"
                                                        :max="quantity"
                                                        required
                                                        class="w-full border border-gray-300 rounded-md p-2" />
                                                </div>

                                                <!-- Recipient Input -->
                                                <select name="country_id" class="border rounded p-2 w-full bg-black">
                                                    <option value="" disabled selected>Select a country</option>
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>

                                                <button
                                                    type="submit"
                                                    class="px-6 py-4 whitespace-nowrap text-sm border rounded-md text-zinc-200 transition-colors hover:bg-red-600 hover:text-black">
                                                    Send Gift 🎁
                                                </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500">
                                    You have no weapons in your personal inventory.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $weapons->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
