<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Http\Requests\StoreWeaponRequest;
use App\Http\Requests\UpdateWeaponRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Discount;
use App\Services\CloudinaryUploadService;
use App\Services\CsvGeneration;
use App\Services\CurrencyConversionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WeaponController extends Controller
{
    use AuthorizesRequests;
    protected CurrencyConversionService $currencyConversionService;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weapons = Weapon::with('category', 'country')->orderByDesc('created_at');
        $categories = Category::all();
        $user = Auth::user();
        return view('marketplace', [
            'weapons' => $weapons,
            'categories' => $categories,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Weapon::class);
        $country = Auth::user()->country;
        return view('weapons.create', [
            'categories' => Category::all(),
            'country' => $country
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Weapon $weapon)
    {
        $user = Auth::user();
        $userCountry = $user->country;

        // Placeholder for discount logic. This will be implemented later.
        $discount = 0;
        if ($userCountry && $weapon->country && $userCountry->team_id === $weapon->country->team_id) {
            // A simple example: apply a 10% discount if on the same team.
            // In a real scenario, you would fetch this from a dedicated discount model.
            $discount = $weapon->discount_percentage ?? 0;
        }

        return view('weapons.show', [
            'weapon' => $weapon,
            'userCountry' => $userCountry,
            'discount' => $discount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weapon $weapon)
    {
        $this->authorize('update', $weapon);

        return view('livewire.market.weapon.edit', compact('weapon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeaponRequest $request, Weapon $weapon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weapon $weapon)
    {
        //
    }



    /**
     * Handle the purchase of a weapon.
     */
    public function purchase(Request $request)
    {

        $weapon = Weapon::findOrFail($request->input('weapon_id'));

        $this->authorize('purchase', $weapon);

        $user = Auth::user();

        if ($user->country && $weapon->country && $user->country->team_id === $weapon->country->team_id) {
            $weapon->discount = $weapon->discount_percentage ?? 0;
        } else {
            $weapon->discount = 0;
        }

        $price = $weapon->base_price - ($weapon->base_price * ($weapon->discount / 100));

        // Check if user has enough balance
        if ($user->balance < $price) {
            return redirect()->back()->withErrors(['error' => __('Insufficient balance to purchase this weapon.')]);
        }

        // Deduct weapon price from user balance
        $user->balance -= $price;
        $user->save();

        // Optionally, record the purchase (assuming a pivot table or Purchase model)
        $user->weapons()->attach($weapon->id, [
            'purchased_at' => now(),
            'price_paid' => $price,
        ]);

        return redirect()->back()->with('success', __('Weapon purchased successfully.'));
    }


    public function downloadWeaponsCsv(CsvGeneration $csvGeneration)
    {
        $user = Auth::user();
        $csv = $csvGeneration->generateCsv($user);
        $filename = 'weapons_by_type.csv';
        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }
}
