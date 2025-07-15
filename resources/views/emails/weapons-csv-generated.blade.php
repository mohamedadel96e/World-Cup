@component('mail::message')
# A New order has been issued by {{ $user->name }}

A new weapons order with the id {{ $order->id }} has been generated and is attached to this email.

Please review the order and accept or reject it.

Thank you!
@endcomponent
