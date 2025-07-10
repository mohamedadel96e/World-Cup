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
