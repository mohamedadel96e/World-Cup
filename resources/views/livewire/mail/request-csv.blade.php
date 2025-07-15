<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Mail\WeaponsCsvGenerated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    public $categories;
    public $quantities = [];
    public $csvUrl = null;
    public $mailQueued = false;

    public function mount(): void
    {
        $this->categories = Category::all();
        foreach ($this->categories as $category) {
            $this->quantities[$category->id] = 0;
        }
    }

    public function generateCsv(): void
    {
        $csvHeader = $this->categories->pluck('name')->implode(',');
        $csvRow = collect($this->categories)->map(fn($cat) => $this->quantities[$cat->id] ?? 0)->implode(',');
        $csv = $csvHeader . "\n" . $csvRow . "\n";
        $filename = 'requested_weapons_by_category.csv';
        $path = storage_path('app/public/' . $filename);
        file_put_contents($path, $csv);
        $this->csvUrl = asset('storage/' . $filename);

        $currentUser = Auth::user();

        // Create an order record
        $order = Order::create([
            'user_id' => $currentUser->id,
            'status' => 'pending',
        ]);

        $countryId = $currentUser->country_id;
        $users = User::where('country_id', $countryId)->where('role', 'country')->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new WeaponsCsvGenerated($currentUser, $path, $order));
        }
        $this->mailQueued = true;
    }
};
?>

<div
    class="flex justify-center items-center min-h-[60vh] bg-gradient-to-br from-orange-50 via-white to-zinc-100 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 py-12 px-2">
    <div class="w-full max-w-2xl">
        <div class="rounded-3xl shadow-2xl border border-orange-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-8">
            <flux:heading size="2xl"
                class="mb-2 text-center text-orange-600 dark:text-orange-400 font-extrabold tracking-tight">Request
                Weapons by Category</flux:heading>
            <flux:subheading class="mb-8 text-center text-zinc-500 dark:text-zinc-300">Fill in the number of weapons you
                want from each category and generate a CSV file for your request.</flux:subheading>
            <form wire:submit.prevent="generateCsv" class="space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($categories as $category)
                        <div
                            class="flex flex-col gap-2 bg-orange-50 dark:bg-zinc-800 rounded-xl p-4 border border-orange-100 dark:border-zinc-700 shadow-sm">
                            <div class="flex items-center gap-2 mb-1">
                                <flux:icon name="layout-grid" class="text-orange-400 dark:text-orange-300" />
                                <flux:label :for="'cat_'.$category->id"
                                    class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $category->name }}
                                </flux:label>
                            </div>
                            <flux:input id="cat_{{ $category->id }}" type="number" min="0"
                                wire:model="quantities.{{ $category->id }}"
                                class="w-full rounded-lg border-2 border-orange-200 dark:border-zinc-700 focus:border-orange-500 focus:ring-orange-500 bg-white dark:bg-zinc-900 px-3 py-2 text-lg text-zinc-800 dark:text-zinc-100 shadow-sm" />
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end mt-6">
                    <flux:button type="submit" variant="primary"
                        class="px-8 py-3 text-lg rounded-xl shadow-lg bg-orange-600 hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600 transition">
                        Generate CSV and send request</flux:button>
                </div>
                @if($csvUrl)
                    <div class="flex justify-center mt-8">
                        <a href="{{ $csvUrl }}"
                            class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition text-lg"
                            download>
                            <flux:icon name="chevrons-up-down" class="inline-block mr-2 align-middle" />
                            Download CSV
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
