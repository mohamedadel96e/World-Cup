<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Services\CsvGeneration;
use App\Services\CurrencyConversionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeaponController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the specified resource.
     */
    public function show(Weapon $weapon, CurrencyConversionService $currencyService)
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

        $weapon->display_price = $currencyService->convert(
            amount: $weapon->base_price,
            fromCurrency: $weapon->country->currency_code,
            toCurrency: $userCountry->currency_code
        );

        return view('weapons.show', [
            'weapon' => $weapon,
            'userCountry' => $userCountry,
            'discount' => $discount,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weapon $weapon)
    {
        $this->authorize('delete', $weapon);
        $weapon->delete();
        return redirect()->route('marketplace')->with('success', __('Weapon deleted successfully.'));
    }


    /**
     * Handle the purchase of a weapon.
     */
    public function purchase(Request $request, CurrencyConversionService $currencyService): RedirectResponse
    {
        $request->validate(['weapon_id' => 'required|integer|exists:weapons,id']);

        $weapon = Weapon::findOrFail($request->input('weapon_id'));
        $user = Auth::user();

        // Authorize the purchase action using your policy
        $this->authorize('purchase', $weapon);

        // --- Step 1: Convert Weapon Price to User's Currency ---
        $priceInUserCurrency = $currencyService->convert(
            amount: $weapon->base_price,
            fromCurrency: $weapon->country->currency_code,
            toCurrency: $user->country->currency_code
        );

        if ($priceInUserCurrency === null) {
            return back()->withErrors(['error' => 'Could not determine the price in your currency.']);
        }

        // --- Step 2: Calculate Discount (if applicable) ---
        $discountPercentage = 0;
        $discountPercentage = $user->can('hasDiscount', $weapon) ? $weapon->discount_percentage : 0;

        // --- Step 3: Calculate Final Price ---
        $finalPrice = $priceInUserCurrency - ($priceInUserCurrency * ($discountPercentage / 100));

        // --- Step 4: Verify User Balance ---
        if ($user->balance < $finalPrice) {
            return back()->withErrors(['error' => 'Insufficient balance to purchase this weapon.']);
        }

        // --- Step 5: Process Transaction ---
        try {
            // Deduct the final, converted price from user balance
            $user->balance -= $finalPrice;
            $weaponCountry = $weapon->country;
            $weaponCountry->balance += $finalPrice;

            // Record the purchase in the pivot table
            $user->weapons()->attach($weapon->id, [
                'purchased_at' => now(),
                'price_paid' => $finalPrice, // Store the price that was actually paid
                'currency' => $user->country->currency_code, // Store the currency for the record
            ]);

            DB::transaction(function () use ($user, $weapon, $finalPrice) {
                $weapon->country->weapons()->updateExistingPivot($weapon->id, [
                    'quantity' => DB::raw('quantity - 1'), // Decrease the weapon quantity
                ]);

                $user->weapons()->updateExistingPivot($weapon->id, [
                    'purchased_at' => now(),
                    'price_paid' => $finalPrice, // Store the price that was actually paid
                    'currency' => $user->country->currency_code, // Store the currency for the record
                ]);
                $user->decrement('balance', $finalPrice);
                $weapon->country->increment('balance', $weapon->base_price);
            });


        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred during the transaction. Please try again.']);
        }

        return redirect()->route('marketplace')->with('success', 'Weapon purchased successfully!');
    }


    
}
