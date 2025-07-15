<?php


use App\Models\Category;

use App\Models\Weapon;

use App\Services\CloudinaryUploadService;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use Livewire\Attributes\Layout;

use Livewire\Volt\Component;

use Livewire\WithFileUploads;


return new #[Layout('components.layouts.app')] class extends Component {

    use WithFileUploads;


    public Weapon $weapon;


    // Form properties

    public string $name = '';

    public string $description = '';

    public ?int $category_id = null;

    public ?float $base_price = null;

    public ?int $discount_percentage = 0;

    public bool $is_available = true; // Changed from is_banned

    public $image_path;


    // Data for the view

    public $categories;

    public $country;

    public $userCountry;


    public function mount(Weapon $weapon): void

    {

        $this->authorize('update', $weapon);

        $this->weapon = $weapon;

        $this->categories = Category::all();

        $this->country = $weapon->country;

        $this->userCountry = Auth::user()->country;


        // Pre-fill form values

        $this->name = $weapon->name;

        $this->description = $weapon->description;

        $this->category_id = $weapon->category_id;

        $this->base_price = $weapon->base_price;

        $this->discount_percentage = $weapon->discount_percentage;

        $this->is_available = $weapon->is_available; // Changed from is_banned

    }


    public function save(CloudinaryUploadService $cloudinary): void

    {

        $validated = $this->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'category_id' => 'required|integer|exists:categories,id',

            'base_price' => 'required|numeric|min:0',

            'discount_percentage' => 'nullable|integer|min:0|max:100',

            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',

        ]);


        if ($this->image_path) {

            $folder = 'weapon_images';

            $publicId = Str::slug($this->name) . '-' . time();

            $uploadedUrl = $cloudinary->upload($this->image_path, $folder, $publicId);


            if ($uploadedUrl) {
                $this->weapon->image_path = $uploadedUrl; // Store the URL directly
            }

        }

        $this->weapon->update( [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'base_price' => $this->base_price,
            'discount_percentage' => $this->discount_percentage,
            'is_available' => $this->is_available,
        ]);


        session()->flash('status', 'Weapon successfully updated!');

    }


    /**

     * Toggles the availability status of the weapon.

     * This action is restricted to admins by the 'ban' policy.

     */

    public function toggleAvailability(): void

    {

        $this->authorize('ban', $this->weapon); // The permission is still to 'ban' or control availability


        $this->weapon->update(['is_available' => !$this->weapon->is_available]);

        $this->is_available = $this->weapon->is_available; // Sync local property


        $status = $this->weapon->is_available ? 'available' : 'unavailable';

        session()->flash('status', "Weapon has been made {$status}.");

    }


    /**

     * Deletes the weapon from the database.

     */

    public function delete(): void

    {

        $this->authorize('delete', $this->weapon);
        $this->weapon->delete();


        session()->flash('status', 'Weapon has been permanently removed from the Market.');

        $this->redirect(route('stockpile.index'), navigate: true);

    }


    public function getPreviewWeaponProperty(): Weapon

    {

        $category = $this->categories->firstWhere('id', $this->category_id);


        $weapon = clone $this->weapon;

        $weapon->name = $this->name;

        $weapon->description = $this->description;

        $weapon->base_price = $this->base_price;

        $weapon->discount_percentage = $this->discount_percentage;

        $weapon->category_id = $this->category_id;

        $weapon->is_available = $this->is_available; // Changed from is_banned

        $weapon->image_path = $this->image_path ? $this->image_path->temporaryUrl() : $weapon->image_path;


        if ($category) {

            $weapon->setRelation('category', $category);

        }

        $weapon->setRelation('country', $this->country);


        return $weapon;

    }


};


?>


<div>

    <x-slot name="header">

        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

            {{ __('Edit Weapon: ') }} {{ $weapon->name }}

        </h2>

    </x-slot>


    <div class="py-2">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

                <!-- Form -->

                <div class="lg:col-span-3 space-y-8">

                    <form wire:submit="save" class="space-y-6 bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow-xl">

                        {{-- Form fields remain the same --}}

                        <div class="space-y-2">

                            <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Weapon Name</label>

                            <input type="text" wire:model.live.debounce="name" id="name" required class="w-full rounded-lg border-2 p-1.5 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm border-orange-500 focus:outline-none focus:ring-0 focus:ring-offset-0">

                            @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                        </div>

                        <div class="space-y-2">

                            <label for="category_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Category</label>

                            <select wire:model.live.debounce="category_id" id="category_id" required class="w-full rounded-lg border-2 p-1.5 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0">

                                <option value="">Select a category...</option>

                                @foreach($categories as $category)

                                <option value="{{ $category->id }}">{{ $category->name }}</option>

                                @endforeach

                            </select>

                            @error('category_id') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                        </div>

                        <div class="space-y-2">

                            <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>

                            <textarea wire:model.live.debounce="description" id="description" rows="4" class="w-full rounded-lg border-2 p-1.5 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0"></textarea>

                            @error('description') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                            <div class="space-y-2">

                                <label for="base_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base Price (in {{ $country->currency_code }})</label>

                                <input type="number" step="0.01" wire:model.live.debounce="base_price" id="base_price" required class="w-full rounded-lg border-2 p-1.5 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0">

                                @error('base_price') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                            </div>

                            <div class="space-y-2">

                                <label for="discount_percentage" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Discount (%)</label>

                                <input type="number" wire:model.live.debounce="discount_percentage" id="discount_percentage" class="w-full rounded-lg border-2 p-1.5 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0">

                                @error('discount_percentage') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                            </div>

                        </div>

                        <div class="space-y-2">

                            <label for="image_path" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Weapon Image</label>

                            <input type="file" wire:model.live="image_path" id="image_path" class="w-full hover:cursor-pointer text-sm text-zinc-500 file:rounded-md border dark:border-zinc-700 rounded-lg file:border-0 file:bg-orange-100 file:px-4 file:py-2 dark:file:bg-zinc-800 dark:file:text-zinc-200" />

                            @error('image_path') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

                        </div>


                        {{-- Action Buttons --}}

                        <div class="pt-4 flex justify-between items-center">

                            {{-- Delete Button --}}

                            <button

                                type="button"

                                wire:click="delete"

                                wire:confirm="Are you sure you want to permanently delete this weapon? This action cannot be undone."

                                class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 text-sm font-semibold border border-neutral-500 p-3 rounded-xl hover:cursor-pointer"

                            >

                                Delete Weapon

                            </button>


                            <div class="flex items-center gap-4">

                                @if (session()->has('status'))

                                    <span x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="text-sm font-semibold text-green-600 dark:text-green-400">

                                        {{ session('status') }}

                                    </span>

                                @endif

                                <button type="submit" class=" bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 hover:cursor-pointer">

                                    <span wire:loading.remove wire:target="save">Update Weapon</span>

                                    <span wire:loading wire:target="save">Saving...</span>

                                </button>

                            </div>

                        </div>

                    </form>


                    {{-- Admin-only Actions --}}

                    @can('ban', $weapon)

                        <div class="mt-8 border-t border-zinc-200 dark:border-zinc-700 pt-6">

                             <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Admin Actions</h3>

                             <div class="mt-4 flex items-center justify-between rounded-lg bg-zinc-100 dark:bg-zinc-800 p-4">

                                <div>

                                    <p class="font-semibold text-zinc-800 dark:text-zinc-200">Availability Status</p>

                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">

                                        {{ $is_available ? 'This weapon is currently ACTIVE in the marketplace.' : 'This weapon is currently UNAVAILABLE.' }}

                                    </p>

                                </div>

                                <button

                                    type="button"

                                    wire:click="toggleAvailability"

                                    class="font-semibold hover:cursor-pointer px-4 py-2 rounded-lg text-sm transition-colors {{ $is_available ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}"

                                >

                                    {{ $is_available ? 'Make Unavailable' : 'Make Available' }}

                                </button>

                             </div>

                        </div>

                    @endcan

                </div>


                <!-- Live Preview -->

                <div class="lg:col-span-2">

                    <div class="sticky top-24 space-y-4">

                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Live Preview</h3>

                        <x-marketplace.weapons.weapon-card

                            :weapon="$this->previewWeapon"

                            :userCountry="$this->userCountry"

                            :discount="$this->discount_percentage"

                            :manageImage="true"

                        />

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
