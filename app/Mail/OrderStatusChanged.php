<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\SupplyRequest;
use App\Models\User;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $status;

    public function __construct(SupplyRequest $order, User $user, string $status)
    {
        $this->order = $order;
        $this->user = $user;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Your Order Has Been ' . ucfirst($this->status))
            ->markdown('emails.order-status-changed')
            ->with([
                'order' => $this->order,
                'user' => $this->user,
                'status' => $this->status,
            ]);
    }
}
