<?php

namespace App\Services;

use App\Mail\SupplyRequestResponseMail;
use App\Models\Country;
use App\Models\SupplyRequest;
use App\Models\User;
use App\Models\Weapon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SupplyRequestService
{
    public CurrencyConversionService $currencyConversionService;

    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }
    // Logic with the CSV (Not Working correctly)
    /*
    public function process(SupplyRequest $supplyRequest): bool
    {
        $general = $supplyRequest->user;
        $country = $general->country;
        // array_shift($csvData); // Uncomment if your CSV has a header row

        // Check if the CSV file exists in storage
        if (!$supplyRequest->csv_path || !Storage::disk('public')->exists($supplyRequest->csv_path)) {
            $supplyRequest->update(['status' => 'failed', 'notes' => 'Original request file was not found.']);
            return false;
        }
        $csvData = array_map('str_getcsv', file(Storage::disk('public')->path($supplyRequest->csv_path)));
        // dd($csvData);

        if (isset($csvData[0]) && $csvData[0][0] === 'weapon_id') {
            array_shift($csvData);
        }

        DB::transaction(function () use ($csvData, $supplyRequest, $country) {
            foreach ($csvData as $row) {
                $weaponId = $row[0];
                // $weaponName = $row[1]; // Not used if we rely on ID, but good to have
                $quantityRequested = (int) $row[2];

                $weapon = Weapon::find($weaponId);
                $status = 'Unavailable';
                $notes = 'Weapon blueprint not found in central command.';

                if ($weapon) {
                    $stock = $country->weapons()->where('weapon_id', $weapon->id)->first();
                    $stockQuantity = $stock ? $stock->pivot->quantity : 0;

                    if ($stockQuantity >= $quantityRequested) {
                        $status = 'Provided';
                        $notes = "Provided from existing stockpile.";
                        // Decrement stock
                        $country->weapons()->updateExistingPivot($weapon->id, [
                            'quantity' => DB::raw("quantity - $quantityRequested")
                        ]);
                    } else {
                        $needed = $quantityRequested - $stockQuantity;
                        $cost = $weapon->country_id === $country->id ? $weapon->manufacturer_price : $weapon->base_price;
                        $totalCost = $needed * $cost;
                        $totalCostInCountryCurrency = $this->currencyConversionService->convert($totalCost, $weapon->country->currency_code, $country->currency_code);
                        if ($country->balance >= $totalCostInCountryCurrency) {
                            $status = 'Purchase Required';
                            $notes = "{$stockQuantity} provided from stock. {$needed} units require acquisition at a cost of {$totalCostInCountryCurrency} {$country->currency_code}.";
                            Country::where('id', $weapon->country_id)->increment('balance',
                                $totalCost);
                            $country->balance -= $totalCostInCountryCurrency;
                            //! note
                            $country->save();
                        } else {
                            $status = 'Unavailable';
                            $notes = "Insufficient funds to acquire the remaining {$needed} units.";
                        }
                    }
                }

                $supplyRequest->items()->where('weapon_id', $weaponId)
                ->update(['status' => $status, 'notes' => $notes]);
            }
            $supplyRequest->update(['status' => 'completed']);
        });
        // !Note Here
        // Send the confirmation email after the transaction is successful
        Mail::to($general->email)->send(new SupplyRequestResponseMail($supplyRequest));
        return true;
    }
        */

    public function process(SupplyRequest $supplyRequest): bool
    {
        $general = $supplyRequest->user;
        $country = $general->country;

        DB::transaction(function () use ($supplyRequest, $country) {
            // Loop through the items stored in the database for this request
            foreach ($supplyRequest->items as $item) {
                $weapon = $item->weapon; // The related weapon model is already loaded
                $quantityRequested = $item->quantity_requested;

                $status = 'Unavailable';
                $notes = 'Weapon blueprint not found in central command.';
                if ($weapon) {
                    $stock = $country->weapons()->where('weapon_id', $weapon->id)->first();
                    $stockQuantity = $stock ? $stock->pivot->quantity : 0;

                    if ($stockQuantity >= $quantityRequested) {
                        $status = 'Provided';
                        $notes = "Provided from existing stockpile.";
                        // Decrement stock
                        $country->weapons()->updateExistingPivot($weapon->id, [
                            'quantity' => DB::raw("quantity - $quantityRequested")
                        ]);
                    } else {
                        $needed = $quantityRequested - $stockQuantity;
                        $cost = $weapon->country_id === $country->id ? $weapon->manufacturer_price : $weapon->base_price;
                        $totalCost = $needed * $cost;
                        $totalCostInCountryCurrency = $this->currencyConversionService->convert($totalCost, $weapon->country->currency_code, $country->currency_code);

                        if ($country->balance >= $totalCostInCountryCurrency) {
                            $status = 'Purchase Required';
                            $notes = "{$stockQuantity} provided from stock. {$needed} units acquired at a cost of " . number_format($totalCostInCountryCurrency, 2) . " {$country->currency_code}.";

                            // Update balances
                            $country->decrement('balance', $totalCostInCountryCurrency);
                            $weapon->country()->increment('balance', $totalCost); // Increment the manufacturer's balance

                            // Update stock levels
                            if ($stock) {
                                $country->weapons()->updateExistingPivot($weapon->id, ['quantity' => 0]);
                            }
                        } else {
                            $status = 'Unavailable';
                            $notes = "Insufficient funds to acquire the remaining {$needed} units.";
                        }
                    }
                }

                // Update the status and notes for the specific item in the database
                $item->update([
                    'status' => $status,
                    'notes' => $notes,
                ]);
            }
            // Mark the overall request as completed
            $supplyRequest->update(['status' => 'completed']);
        });

        // Send the confirmation email after the transaction is successful
        Mail::to($general->email)->send(new SupplyRequestResponseMail($supplyRequest));

        return true;
    }
}
