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
    public function generateCsv(User $user): string
    {
        $countryId = $user->country_id;

        $weaponsWithCategories = Weapon::where('weapons.country_id', $countryId)
            ->join('categories', 'weapons.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('COUNT(*) as weapon_count'))
            ->groupBy('categories.name')
            ->get();

        $categories = $weaponsWithCategories->pluck('category_name')->toArray();

        if (empty($categories)) {
            return "No weapons found for your country.\n";
        }

        $csv = implode(',', $categories) . "\n";
        $csv .= implode(',', $weaponsWithCategories->pluck('weapon_count')->toArray());
        $csv .= "\n";

        return $csv;
    }

}
