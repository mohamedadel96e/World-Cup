<?php

use App\Models\User;
use App\Mail\WeaponsCsvGenerated;
use App\Models\SupplyRequest;
use App\Models\Weapon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.app')] class extends Component {
    use WithFileUploads;

    public array $quantities = [];
    public ?string $csvUrl = null;
    public bool $mailQueued = false;
    public string $search = ''; // New: Property for the search term

    public function mount(): void
    {
        // Fetch a simple, flat collection just to initialize the quantities array.
        $allWeapons = Weapon::all(['id']);
        foreach ($allWeapons as $weapon) {
            $this->quantities[$weapon->id] = 0;
        }
    }

    public function generateCsv(): void
    {
        $currentUser = Auth::user();
        $requestedWeapons = [];

        // Filter out weapons with a quantity of 0
        foreach ($this->quantities as $weaponId => $quantity) {
            if ((int)$quantity > 0) {
                $weapon = Weapon::find($weaponId);
                if ($weapon) {
                    $requestedWeapons[] = [
                        'id' => $weapon->id,
                        'name' => $weapon->name,
                        'quantity' => (int)$quantity,
                    ];
                }
            }
        }

        if (empty($requestedWeapons)) {
            // Optionally, add feedback to the user that they need to request at least one item.
            return;
        }

        // --- CSV Generation ---
        $csvHeader = "weapon_id,weapon_name,quantity\n";
        $csvRows = collect($requestedWeapons)->map(fn($item) => "{$item['id']},\"{$item['name']}\",{$item['quantity']}")->implode("\n");
        $csv = $csvHeader . $csvRows;

        $filename = 'supply_request_' . now()->format('Ymd_His') . '.csv';
        $path = storage_path('app/public/' . $filename);
        file_put_contents($path, $csv);
        $this->csvUrl = asset('storage/' . $filename);

        // --- Order & Item Record Creation ---
        $supplyRequest = SupplyRequest::create([
            'user_id' => $currentUser->id,
            'status' => 'pending', // This request is now pending fulfillment
        ]); // Want to add the path to the CSV file here for needing it when processing the request

        foreach ($requestedWeapons as $item) {
            $supplyRequest->items()->create([
                'weapon_id' => $item['id'],
                'quantity_requested' => $item['quantity'],
                'status' => 'Pending Review',
            ]);
        }

        // --- Email Logic (Unchanged) ---
        $countryId = $currentUser->country_id;
        $users = User::where('country_id', $countryId)->where('role', 'country')->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new WeaponsCsvGenerated($currentUser, $path, $supplyRequest));
        }
        $this->mailQueued = true;
    }

    /**
     * Prepare the data for the view.
     * This method runs before the component is rendered.
     */
    public function with(): array
    {
        // New: Build the query with the search filter
        $weaponQuery = Weapon::with('category')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });

        return [
            // Get the filtered results and then group them for display
            'weapons' => $weaponQuery->orderBy('category_id')->get()->groupBy('category.name'),
        ];
    }
};
?>

<div class="flex justify-center items-center min-h-[60vh] bg-gradient-to-br from-orange-50 via-white to-zinc-100 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 py-12 px-2">
    <div class="w-full max-w-4xl">
        <div class="rounded-3xl shadow-2xl border border-orange-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-8">
            <h2 class="mb-2 text-center text-3xl font-extrabold tracking-tight text-orange-600 dark:text-orange-400">
                Submit Weapon Requisition
            </h2>
            <p class="mb-8 text-center text-zinc-500 dark:text-zinc-300">
                Specify the quantity needed for each weapon. Your request will be dispatched to High Command.
            </p>

            <!-- New: Search Input -->
            <div class="mb-8">
                <div class="relative">
                     <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    </div>
                    <input
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search for a weapon blueprint..."
                        class="w-full rounded-full border-2 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                </div>
            </div>


            <form wire:submit.prevent="generateCsv" class="space-y-8">
                <div class="space-y-8">
                    @forelse($weapons as $categoryName => $weaponGroup)
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                                {{ $categoryName }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($weaponGroup as $weapon)
                                    <div class="flex flex-col gap-2 bg-orange-50 dark:bg-zinc-800 rounded-xl p-4 border border-orange-100 dark:border-zinc-700 shadow-sm">
                                        <label for="weapon_{{ $weapon->id }}" class="font-semibold text-zinc-700 dark:text-zinc-200">
                                            {{ $weapon->name }}
                                        </label>
                                        <input id="weapon_{{ $weapon->id }}" type="number" min="0"
                                               wire:model="quantities.{{ $weapon->id }}"
                                               class="w-full rounded-lg border-2 border-orange-200 dark:border-zinc-700 focus:border-orange-500 focus:ring-orange-500 bg-white dark:bg-zinc-900 px-3 py-2 text-lg text-zinc-800 dark:text-zinc-100 shadow-sm"
                                               placeholder="0"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-zinc-500 dark:text-zinc-400">No weapons found matching your search.</p>
                        </div>
                    @endforelse
                </div>

                <div class="flex flex-col items-center justify-center mt-6 gap-6">
                    <button type="submit"
                            class="px-8 py-3 text-lg rounded-xl shadow-lg bg-orange-600 hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600 text-white font-semibold transition w-full max-w-xs">
                        <span wire:loading.remove wire:target="generateCsv">Generate & Send Request</span>
                        <span wire:loading wire:target="generateCsv">Processing...</span>
                    </button>

                    @if($csvUrl)
                        <div class="text-center">
                            <p class="text-green-600 dark:text-green-400 font-semibold mb-2">Request sent successfully!</p>
                            <a href="{{ $csvUrl }}"
                               class="inline-flex items-center gap-2 px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition text-lg"
                               download>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v4.59L7.3 9.24a.75.75 0 0 0-1.1 1.02l3.25 3.5a.75.75 0 0 0 1.1 0l3.25-3.5a.75.75 0 0 0-1.1-1.02l-1.95 2.1V6.75Z" clip-rule="evenodd" /></svg>
                                Download Generated CSV
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
