@component('mail::message')
# Order Status Update

Your order with ID {{ $order->id }} has been **{{ ucfirst($status) }}**.

@if($status === 'accepted')
    Your order has been accepted and will be processed.
@else
    Unfortunately, your order has been rejected.
@endif

Thank you!
@endcomponent
