<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StockpileController;
use App\Http\Controllers\SupplyRequestController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WeaponController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Volt::route('marketplace', 'marketplace.index')
    ->middleware(['auth', 'verified'])
    ->name('marketplace');

Route::post('weapons/purchase', [WeaponController::class, 'purchase'])
    ->name('weapons.purchase');


// Route::get('marketplace/category/{category}', [MarketplaceController::class, 'showByCategory'])
//     ->middleware(['auth', 'verified'])
//     ->name('marketplace.category');


Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('weapons/create', 'weapons.create')->name('weapons.create');
    Volt::route('marketplace/{weapon}/edit', 'weapons.edit')->name('weapons.edit');
    Route::get('marketplace/{weapon}', [WeaponController::class, 'show'])
        ->name('marketplace.show');
    Route::post('weapons', [WeaponController::class, 'store'])
        ->name('weapons.store');
    Route::delete('weapons/{weapon}', [WeaponController::class, 'destroy'])
        ->name('marketplace.destroy');
    Route::get('weapons/csv/download', [WeaponController::class, 'downloadWeaponsCsv'])
        ->name('weapons.csv.download');

    Volt::route('mail/request-csv', 'mail.request-csv')->name('mail.request-csv')
        ->middleware(EnsureUserHasRole::class . ':general');

    Route::get('stockpile', [StockpileController::class, 'index'])
        ->name('stockpile.index')
        ->middleware([EnsureUserHasRole::class . ':admin,country']);
});


Route::middleware(['auth', EnsureUserHasRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('weapons', \App\Http\Controllers\Admin\WeaponController::class);
    Route::resource('countries', \App\Http\Controllers\Admin\CountryController::class);
    Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    // Add more admin routes here
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'verified', EnsureUserHasRole::class . ':general'])->prefix('supply')->name('supply.')->group(function () {
    // Route for the CSV upload form, pointing to the Volt component

    // Route for the transaction receipt page
    Route::get('/receipt/{supplyRequest}', [SupplyRequestController::class, 'show'])->name('receipt.show');
});


Route::middleware(['auth', 'verified', EnsureUserHasRole::class . ':admin'])->group(function () {
    // Remove these lines:
    // \Livewire\Livewire::component('admin.insert', \App\Livewire\Admin\Insert::class);
    // Route::get('admin/insert', fn() => view('livewire.admin.insert'))->name('admin.insert');
});


Route::middleware('auth', 'verified')->group(function () {
    Volt::route('inbox', 'inbox')->name('inbox')
        ->middleware(EnsureUserHasRole::class . ':country,admin');
});



Route::get('/history', function () {
    return view('history');
})->name('history');


require __DIR__ . '/auth.php';
