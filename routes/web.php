<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\WeaponController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Volt::route('marketplace', componentName: 'marketplace.index')
    ->middleware(['auth', 'verified'])
    ->name('marketplace');

Route::post('weapons/purchase', [WeaponController::class, 'purchase'])
    ->name('weapons.purchase');


Route::get('marketplace/category/{category}', [MarketplaceController::class, 'showByCategory'])
    ->middleware(['auth', 'verified'])
    ->name('marketplace.category');

Route::get('marketplace/featured', [MarketplaceController::class, 'showFeatured'])
    ->middleware(['auth', 'verified'])
    ->name('marketplace.featured');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('weapons/create', [WeaponController::class, 'create'])
    //     ->name('weapons.create');
    Volt::route('weapons/create', 'weapons.create')->name('weapons.create');
    // Route::get('marketplace/{weapon}/edit', [WeaponController::class, 'edit'])
    //     ->name('marketplace.edit');
    Volt::route('marketplace/{weapon}/edit', 'weapons.edit')->name('weapons.edit');
    Route::get('marketplace/{weapon}', [WeaponController::class, 'show'])
        ->name('marketplace.show');
    Route::post('weapons', [WeaponController::class, 'store'])
        ->name('weapons.store');
    Route::put('marketplace/{weapon}', [WeaponController::class, 'update'])
        ->name('marketplace.update');
    Route::delete('marketplace/{weapon}', [WeaponController::class, 'destroy'])
        ->name('marketplace.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::middleware('auth', 'verified')->group(function () {
    Route::get('inbox', function () {
        return "Hello World";
    })->name('inbox');
});


Route::get('/history', function () {
    return view('history');
})->name('history');


require __DIR__ . '/auth.php';
