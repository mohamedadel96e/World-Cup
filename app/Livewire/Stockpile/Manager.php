<?php

namespace App\Livewire\Stockpile;

use App\Models\Weapon;
use App\Services\CsvGeneration;
use App\Services\CurrencyConversionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportCsv(CsvGeneration $csvService)
    {
        $user = Auth::user();
        $csvData = $csvService->generateCsvForStockpile($user);
        $fileName = 'stockpile_report_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, $fileName);
    }

    /**
     * Render the component.
     * We inject the CurrencyConversionService to calculate local prices.
     */
    public function render(CurrencyConversionService $currencyService)
    {
        $user = Auth::user();
        $userCountry = $user->country;

        $weaponsQuery = $userCountry
            ->weapons()
            ->with(['category', 'country']) // Eager load relationships
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('weapons.created_at');

        $weapons = $weaponsQuery->paginate(10);

        // Loop through the paginated items and add the converted price
        $weapons->getCollection()->transform(function ($weapon) use ($currencyService, $userCountry) {
            $weapon->display_price = $currencyService->convert(
                amount: $weapon->base_price,
                fromCurrency: $weapon->country->currency_code,
                toCurrency: $userCountry->currency_code
            );
            return $weapon;
        });

        return view('livewire.stockpile.manager', [
            'weapons' => $weapons,
        ]);
    }
}
