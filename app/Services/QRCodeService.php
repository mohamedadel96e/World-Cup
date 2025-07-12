<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeService
{
    /**
     * Generate a QR code and return it as a base64 encoded PNG image string.
     * This format is perfect for embedding directly into an email.
     *
     * @param string $data The data to encode (e.g., a URL).
     * @param int $size The size of the QR code in pixels.
     * @return string The base64 encoded PNG string.
     */
    public function generateAsBase64(string $data, int $size = 200): string
    {
        // Generate the QR code as a PNG image binary data
        $pngData = QrCode::format('png')
                         ->size($size)
                         ->errorCorrection('H') // High error correction
                         ->generate($data);

        // Convert the binary PNG data to a base64 string
        return 'data:image/png;base64,' . base64_encode($pngData);
    }

    /**
     * Generate a QR code and return it as an SVG string.
     *
     * @param string $data The data to encode.
     * @param int $size The size of the QR code.
     * @return string The SVG image string.
     */
    public function generateAsSvg(string $data, int $size = 200): string
    {
        return QrCode::format('svg')
                     ->size($size)
                     ->generate($data);
    }
}
