<?php
// Just Nothing
use App\Services\SupplyRequestService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.app')] class extends Component {
    use WithFileUploads;

    public $csvFile;

    public function submit(SupplyRequestService $supplyRequestService)
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:1024', // 1MB Max
        ]);

        try {
            $supplyRequestService->process($this->csvFile, Auth::user());
            session()->flash('status', 'Request submitted. A status report has been dispatched to your email.');
            $this->reset('csvFile');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to process your request. Please check the file format and try again.');
        }
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Submit Supply Requisition
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form wire:submit="submit" class="space-y-6">
                    <div>
                        <label for="csvFile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requisition File (CSV)</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Must contain columns: weapon_id, weapon_name, quantity</p>
                        <input type="file" wire:model="csvFile" id="csvFile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        @error('csvFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if (session('status'))
                        <div class="rounded-md bg-green-100 p-4 dark:bg-green-900 text-sm font-medium text-green-800 dark:text-green-200">{{ session('status') }}</div>
                    @endif
                     @if (session('error'))
                        <div class="rounded-md bg-red-100 p-4 dark:bg-red-900 text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-md bg-orange-600 px-6 py-2 text-white font-semibold shadow-sm hover:bg-orange-500">
                             <span wire:loading.remove wire:target="submit">Submit Request</span>
                             <span wire:loading wire:target="submit">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
