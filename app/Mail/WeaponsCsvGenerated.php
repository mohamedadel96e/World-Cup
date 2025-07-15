<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeaponsCsvGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $csvPath;
    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $csvPath, $order = null)
    {
        $this->user = $user;
        $this->csvPath = $csvPath;
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Order Issued')
            ->markdown('emails.weapons-csv-generated')
            ->with([
                'user' => $this->user,
                'order' => $this->order,
            ])
            ->attach($this->csvPath, [
                'as' => 'requested_weapons_by_category.csv',
                'mime' => 'text/csv',
            ]);
    }
}
