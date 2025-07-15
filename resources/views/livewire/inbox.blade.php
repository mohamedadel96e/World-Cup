<?php
use App\Models\SupplyRequest;
use App\Models\User;
use App\Mail\OrderStatusChanged;
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
            ->with('user')
            ->get();
    }
    public function updateStatus($orderId, $status): void
    {
        $order = SupplyRequest::findOrFail($orderId);
        $order->status = $status;
        $order->save();
        $user = $order->user;
        Mail::to($user->email)->queue(new OrderStatusChanged($order, $user, $status));
        $this->reset(); // Refresh computed properties
    }
};
?>

<div class="max-w-3xl mx-auto py-10">
    <flux:heading size="2xl" class="mb-6 text-center">Country Orders Inbox</flux:heading>
    @if($this->orders->isEmpty())
        <div class="text-center text-zinc-500 dark:text-zinc-400">No pending orders for your country.</div>
    @else
        <div class="space-y-6">
            @foreach($this->orders as $order)
                <div
                    class="flex items-center justify-between bg-white dark:bg-zinc-900 rounded-xl shadow p-6 border border-orange-100 dark:border-zinc-700">
                    <div>
                        <div class="font-semibold text-lg text-orange-700 dark:text-orange-300">Order #{{ $order->id }}</div>
                        <div class="text-zinc-700 dark:text-zinc-200">Ordered by: <span
                                class="font-medium">{{ $order->user->name }}</span></div>
                    </div>
                    <div class="flex gap-3">
                        <flux:button variant="primary" wire:click="updateStatus({{ $order->id }}, 'accepted')" class="bg-green-600 hover:bg-green-700">Accept
                        </flux:button>
                        <flux:button variant="primary" wire:click="updateStatus({{ $order->id }}, 'rejected')" class="bg-red-600 hover:bg-red-700">Reject
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
