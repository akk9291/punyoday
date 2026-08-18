<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * Generate SVG format QR code string for token or URL
     */
    public function generateSvg(string $data, int $size = 200): string
    {
        return QrCode::size($size)
            ->color(128, 0, 32) // Deep Maroon accent
            ->margin(1)
            ->generate($data);
    }

    /**
     * Generate Base64 Data URI string for rendering in Blade/DomPDF img tags
     */
    public function generateBase64DataUri(string $data, int $size = 180): string
    {
        $svg = $this->generateSvg($data, $size);
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
