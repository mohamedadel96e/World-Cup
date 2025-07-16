<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CategoryController,
    CountryController,
    StockpileController,
    SupplyRequestController,
    TeamController,
    WeaponController
};
use App\Http\Middleware\EnsureUserHasRole;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('home');
Route::get('history', fn () => view('history'))->name('history');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Marketplace
    Volt::route('marketplace', 'marketplace.index')->name('marketplace');
    Route::get('marketplace/{weapon}', [WeaponController::class, 'show'])->name('marketplace.show');
    Route::post('weapons/purchase', [WeaponController::class, 'purchase'])->name('weapons.purchase');
    Route::delete('weapons/{weapon}', [WeaponController::class, 'destroy'])->name('marketplace.destroy');

    // Weapon Management
    Volt::route('weapons/create', 'weapons.create')->name('weapons.create');
    Volt::route('marketplace/{weapon}/edit', 'weapons.edit')->name('weapons.edit');
    Route::post('weapons', [WeaponController::class, 'store'])->name('weapons.store');

    // Inventory (restricted to general and country roles)
    Volt::route('inventory', 'inventory.index')
        ->middleware(EnsureUserHasRole::class . ':general,country')
        ->name('inventory.index');

    // Mail Request CSV (only general)
    Volt::route('mail/request-csv', 'mail.request-csv')
        ->middleware(EnsureUserHasRole::class . ':general')
        ->name('mail.request-csv');

    // Stockpile (admin and country)
    Route::get('stockpile', [StockpileController::class, 'index'])
        ->middleware(EnsureUserHasRole::class . ':admin,country')
        ->name('stockpile.index');

    // Inbox (admin and country)
    Volt::route('inbox', 'inbox')
        ->middleware(EnsureUserHasRole::class . ':country,admin')
        ->name('inbox');

    // Settings
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    // Category Routes
    Route::resource('category', CategoryController::class)->except(['index', 'show']);

    // Country Routes
    Route::resource('country', CountryController::class)->except(['index', 'show']);

    // Team Routes
    Route::resource('teams', TeamController::class)->except(['index', 'show']);
});

/*
|--------------------------------------------------------------------------
| Supply Routes (General Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', EnsureUserHasRole::class . ':general'])
    ->prefix('supply')
    ->name('supply.')
    ->group(function () {
        Route::get('receipt/{supplyRequest}', [SupplyRequestController::class, 'show'])->name('receipt.show');
    });

require __DIR__ . '/auth.php';
