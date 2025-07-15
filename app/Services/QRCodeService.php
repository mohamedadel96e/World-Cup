<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

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
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->size($size)
            ->margin(10)
            ->build();

        return base64_encode($result->getString());
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
        $result = Builder::create()
            ->writer(new SvgWriter())
            ->data($data)
            ->size($size)
            ->margin(10)
            ->build();

        return $result->getString(); // SVG string
    }
}
