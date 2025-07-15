<?php

namespace App\Services;

use App\Mail\SupplyRequestResponseMail;
use App\Models\SupplyRequest;
use App\Models\User;
use App\Models\Weapon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SupplyRequestService
{
    public CurrencyConversionService $currencyConversionService;

    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }

    public function process(UploadedFile $file, User $general): SupplyRequest
    {
        $country = $general->country;
        $supplyRequest = $country->supplyRequests()->create(['user_id' => $general->id]);
        dd("hello");
        $csvData = array_map('str_getcsv', file($file->getRealPath()));
        // array_shift($csvData); // Uncomment if your CSV has a header row

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
                        } else {
                            $status = 'Unavailable';
                            $notes = "Insufficient funds to acquire the remaining {$needed} units.";
                        }
                    }
                }

                $supplyRequest->items()->create([
                    'weapon_id' => $weaponId,
                    'quantity_requested' => $quantityRequested,
                    'status' => $status,
                    'notes' => $notes,
                ]);
            }
            $supplyRequest->update(['status' => 'completed']);
        });
        // !Note Here
        // Send the confirmation email after the transaction is successful
        Mail::to($general->email)->send(new SupplyRequestResponseMail($supplyRequest));

        return $supplyRequest;
    }
}
