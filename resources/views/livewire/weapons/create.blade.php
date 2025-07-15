<?php

use App\Models\Category;
use App\Models\Country;
use App\Models\Weapon;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

// Use a full-page layout
new #[Layout('components.layouts.app')] class extends Component {
    use WithFileUploads;

    // Form properties
    public string $name = '';
    public string $description = '';
    public ?int $category_id = null;
    public ?float $base_price = null;
    public ?int $discount_percentage = 0;
    public $image_path; // For new image uploads

    // Data for the view
    public $categories;
    public $country;

    public function mount(): void
    {
        $this->authorize('create', Weapon::class);
        $this->categories = Category::all();
        $this->country = Auth::user()->country;
    }

    public function save(CloudinaryUploadService $cloudinary): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // Handle the image upload
        $folder = 'weapon_images';
        $publicId = Str::slug($this->name) . '-' . time();
        $uploadedUrl = $cloudinary->upload($this->image_path, $folder, $publicId);

        if (!$uploadedUrl) {
            session()->flash('error', 'Image could not be uploaded. Please try again.');
            return;
        }

        Weapon::create([
            'country_id' => $this->country->id,
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'base_price' => $this->base_price,
            'discount_percentage' => $this->discount_percentage,
            'image_path' => $uploadedUrl,
        ]);

        session()->flash('status', 'Weapon successfully added to your arsenal!');
        $this->redirect(route('marketplace'), navigate: true);
    }

    // This computed property creates a "dummy" weapon object for the live preview
    public function getPreviewWeaponProperty(): Weapon
    {
        $category = $this->categories->firstWhere('id', $this->category_id);

        $weapon = new Weapon([
            'name' => $this->name ?: 'Weapon Name',
            'description' => $this->description ?: 'A brief description of the weapon will appear here.',
            'base_price' => $this->base_price,
            'discount_percentage' => $this->discount_percentage,
            'image_path' => $this->image_path ? $this->image_path->temporaryUrl() : null,
            'country_id' => $this->country->id,
            'category_id' => $this->category_id,
        ]);

        if ($category) {
            $weapon->setRelation('category', $category);
        }
        $weapon->setRelation('country', $this->country);

        return $weapon;
    }

}; ?>

<div>

    <div class="py-2">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

                <!-- Form -->
                <div class="lg:col-span-3 space-y-8">
                    <form wire:submit="save" class="space-y-6 bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow-xl">

                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Weapon Name</label>
                            <input type="text" wire:model.live.debounce="name" id="name" required class="w-full rounded-lg border-2 p-1.5  dark:border-zinc-700 dark:bg-zinc-900 shadow-sm border-orange-500 focus:outline-none focus:ring-0 focus:ring-offset-0">
                            @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Category</label>
                            <select wire:model.live.debounce="category_id" id="category_id" required class="w-full  rounded-lg border-2 p-1.5 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0">
                                <option  value="">Select a category...</option>
                                @foreach($this->categories as $category)
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
                                <label for="base_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Base Price (in {{ $this->country->currency_code }})
                                </label>
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

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 hover:cursor-pointer">
                                <span wire:loading.remove wire:target="save">Add Weapon to Arsenal</span>
                                <span wire:loading wire:target="save">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Live Preview -->
                <div class="lg:col-span-2">
                    <div class="sticky top-24 space-y-4">
                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Live Preview</h3>
                        <x-marketplace.weapons.weapon-card :weapon="$this->previewWeapon" :discount="$this->discount_percentage" :manageImage="true" :userCountry="$this->country"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

