<?php

use App\Models\SupplyRequest;
use App\Models\User;
use App\Mail\OrderStatusChanged;
use App\Services\SupplyRequestService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    public function getOrdersProperty()
    {
        $countryId = Auth::user()->country_id;
        return SupplyRequest::where('status', 'pending')
            ->whereHas('user', function ($query) use ($countryId) {
                $query->where('country_id', $countryId);
            })
            ->with(['user', 'items', 'items.weapon']) // Eager load all necessary relationships
            ->latest()
            ->get();
    }

    public function updateStatus($orderId, $status, SupplyRequestService $supplyRequestService): void
    {
        $order = SupplyRequest::findOrFail($orderId);

        if ($status === 'accepted') {
            $supplyRequestService->process($order);
        } else {
            $order->status = 'rejected';
            $order->save();
            $user = $order->user;
            // You might want a different email for rejections
            Mail::to($user->email)->queue(new OrderStatusChanged($order, $user, $status));
        }

        $this->dispatch('$refresh');
    }
};
?>

<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-zinc-800 dark:text-zinc-100">Incoming Requisitions</h2>
        <p class="mt-2 text-md text-zinc-600 dark:text-zinc-400">Review and process pending supply requests from your Generals.</p>
    </div>

    @if($this->orders->isEmpty())
    <div class="text-center bg-white dark:bg-zinc-900 rounded-xl shadow p-12 border border-zinc-200 dark:border-zinc-800">
        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-zinc-900 dark:text-zinc-100">All Clear</h3>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">There are no pending supply requests at this time.</p>
    </div>
    @else
    <div class="space-y-6">
        @foreach($this->orders as $order)
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg p-6 border border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-4 border-b border-zinc-200 dark:border-zinc-700">
                <div>
                    <div class="font-bold text-xl text-orange-600 dark:text-orange-400">Requisition #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                        From: <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $order->user->name }}</span> |
                        Date: <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 flex gap-3 flex-wrap">
                    <button wire:click="updateStatus({{ $order->id }}, 'accepted')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg shadow-sm hover:bg-green-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                        </svg>
                        Accept
                    </button>
                    <button wire:click="updateStatus({{ $order->id }}, 'rejected')" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg shadow-sm hover:bg-red-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        Reject
                    </button>

                    @if($order->csv_path)
                    <a href="{{ $order->csv_path }}" target="_blank" download
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.5v11.25m0 0L8.25 12m3.75 3.75L15.75 12M4.5 20.25h15" />
                        </svg>
                        Download CSV
                    </a>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <h4 class="font-semibold text-zinc-800 dark:text-zinc-200 mb-2">Requested Items:</h4>
                <ul class="space-y-2">
                    @foreach($order->items as $item)
                    <li class="flex items-center justify-between text-sm bg-orange-50 dark:bg-zinc-800 p-3 rounded-lg">
                        <span class="text-zinc-700 dark:text-zinc-200">{{ $item->weapon->name }}</span>
                        <span class="font-bold text-orange-700 dark:text-orange-300">Qty: {{ $item->quantity_requested }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
