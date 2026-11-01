<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;

class QrCodeService
{
    public static function generateDataUri(string $data): string
    {
        return (new QRCode())->render($data);
    }
}
