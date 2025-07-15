<?php

namespace App\Mail;

use App\Models\SupplyRequest;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\QRCodeService;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
// use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;

class SupplyRequestResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public SupplyRequest $supplyRequest;
    public string $qrCode;


    /**
     * Create a new message instance.
     */
    public function __construct(SupplyRequest $supplyRequest)
    {
        $this->supplyRequest = $supplyRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Supply Request Response Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $qrCodeService = app(QRCodeService::class);
        $url = route('supply.receipt.show', $this->supplyRequest);
        $this->qrCode = $qrCodeService->generateAsBase64($url);
        return new Content(
            view: 'emails.supply.response',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
