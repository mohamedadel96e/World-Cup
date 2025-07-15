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


Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('category/create', [CategoryController::class, 'create'])
        ->name('category.create');
    Route::post('category', [CategoryController::class, 'store'])
        ->name('category.store');
    Route::get('category/{category}/edit', [CategoryController::class, 'edit'])
        ->name('category.edit');
    Route::put('category/{category}', [CategoryController::class, 'update'])
        ->name('category.update');
    Route::delete('category/{category}', [CategoryController::class, 'destroy'])
        ->name('category.destroy');

    Route::get('country/create', [CountryController::class, 'create'])
        ->name('country.create');
    Route::post('country', [CountryController::class, 'store'])
        ->name('country.store');
    Route::get('country/{country}/edit', [CountryController::class, 'edit'])
        ->name('country.edit');
    Route::put('country/{country}', [CountryController::class, 'update'])
        ->name('country.update');
    Route::delete('country/{country}', [CountryController::class, 'destroy'])
        ->name('country.destroy');

    Route::get('teams/create', [TeamController::class, 'create'])
        ->name('team.create');
    Route::post('teams', [TeamController::class, 'store'])
        ->name('team.store');
    Route::get('teams/{team}/edit', [TeamController::class, 'edit'])
        ->name('team.edit');
    Route::put('teams/{team}', [TeamController::class, 'update'])
        ->name('team.update');
    Route::delete('teams/{team}', [TeamController::class, 'destroy'])
        ->name('team.destroy');

});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', EnsureUserHasRole::class . ':general'])->prefix('supply')->name('supply.')->group(function () {
    // Route for the CSV upload form, pointing to the Volt component

    // Route for the transaction receipt page
    Route::get('/receipt/{supplyRequest}', [SupplyRequestController::class, 'show'])->name('receipt.show');
});





Route::middleware('auth', 'verified')->group(function () {
    Volt::route('inbox', 'inbox')->name('inbox')
    ->middleware(EnsureUserHasRole::class . ':country,admin');
});

Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Mailtrap SMTP!', function ($message) {
        $message->to('mohamedadel96k@gmail.com')
                ->subject('Test Email via Mailtrap SMTP');
    });

    return 'Email sent!';
});


Route::get('history', function () {
    return view('history');
})->name('history');


require __DIR__ . '/auth.php';
