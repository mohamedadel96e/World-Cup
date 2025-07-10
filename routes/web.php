<?php

use App\Http\Controllers\WeaponController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::get('marketplace', [WeaponController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('marketplace');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('marketplace/create', [WeaponController::class, 'create'])
        ->name('marketplace.create');
    Route::get('marketplace/{weapon}/edit', [WeaponController::class, 'edit'])
        ->name('marketplace.edit');
    Route::get('marketplace/{weapon}', [WeaponController::class, 'show'])
        ->name('marketplace.show');
    Route::post('marketplace', [WeaponController::class, 'store'])
        ->name('marketplace.store');
    Route::put('marketplace/{weapon}', [WeaponController::class, 'update'])
        ->name('marketplace.update');
    Route::delete('marketplace/{weapon}', [WeaponController::class, 'destroy'])
        ->name('marketplace.destroy');

    Route::post('weapons/purchase', [WeaponController::class, 'purchase'])
        ->name('weapons.purchase');
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

require __DIR__.'/auth.php';
