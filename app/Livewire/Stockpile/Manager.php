<?php

namespace App\Livewire\Stockpile;

use App\Models\Weapon;
use App\Services\CsvGeneration;
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
        $csvData = $csvService->generateCsv($user);
        $fileName = 'stockpile_report_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, $fileName);
    }

    public function render()
    {
        $user = Auth::user();
        $countryId = $user->country_id;

        $weapons = Weapon::with('category')
            ->where('country_id', $countryId)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10); // 10 items per page for the table

        return view('livewire.stockpile.manager', [
            'weapons' => $weapons,
        ]);
    }
}
