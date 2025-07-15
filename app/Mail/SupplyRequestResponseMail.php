<?php

namespace App\Mail;

use App\Models\SupplyRequest;
use Illuminate\Bus\Queueable;
use App\Services\QRCodeService;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SupplyRequestResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public SupplyRequest $supplyRequest;

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
            subject: 'Supply Request Response',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
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
        // 1. Generate the QR Code PNG data using the service
        $qrCodeService = app(QRCodeService::class);
        $url = route('supply.receipt.show', $this->supplyRequest);
        $qrCodePngData = $qrCodeService->generateAsBase64($url); // Assuming a method that returns raw PNG data

        // 2. Create the attachment from the raw data
        return [
            Attachment::fromData(fn () => $qrCodePngData, 'qrcode.png')
                ->withMime('image/png'),
        ];
    }
}
