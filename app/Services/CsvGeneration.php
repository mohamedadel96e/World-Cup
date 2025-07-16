<?php

namespace App\Services;

use App\Models\User;
use App\Models\Weapon;
use Illuminate\Support\Facades\DB;

class CsvGeneration
{
    /**
     * Generate a CSV of available weapon counts by category for the user's country.
     * Each column is a weapon category, and the value is the total available for that category.
     *
     * @param User $user
     * @return string CSV string
     */
    public function generateCsvForStockpile(User $user): string
    {
        // This query fetches all individual weapons in the country's stockpile,
        // joining with other tables to get all necessary details.
        $stockpileItems = DB::table('country_weapon')
            ->join('weapons', 'country_weapon.weapon_id', '=', 'weapons.id')
            ->join('categories', 'weapons.category_id', '=', 'categories.id')
            ->join('countries as manufacturer', 'weapons.country_id', '=', 'manufacturer.id') // Join to get manufacturer name
            ->where('country_weapon.country_id', $user->country_id)
            ->select(
                'weapons.name as weapon_name',
                'manufacturer.name as manufacturer_name',
                'categories.name as category_name',
                'country_weapon.quantity'
            )
            ->orderBy('weapon_name')
            ->get();

        if ($stockpileItems->isEmpty()) {
            return "Weapon Name,Manufacturer,Category,Quantity\nNo weapons found in your country's stockpile.\n";
        }

        // Build the CSV string
        $csvHeader = "Weapon Name,Manufacturer,Category,Quantity\n";
        $csvRows = $stockpileItems->map(function ($item) {
            // Escape commas in names by enclosing the name in double quotes
            $weaponName = '"' . str_replace('"', '""', $item->weapon_name) . '"';
            return "{$weaponName},{$item->manufacturer_name},{$item->category_name},{$item->quantity}";
        })->implode("\n");

        return $csvHeader . $csvRows;
    }

}
