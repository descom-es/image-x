<?php

namespace Descom\ImageX\Formats;

use Descom\ImageX\Http\Header;

final class JpgFormat extends Format implements FormatContract
{
    protected string $mimeTypes = 'image/jpg';
    protected string $gdInfoKey = 'JPEG Support';

    public function extension(): string
    {
        return 'jpg';
    }

    protected function isServerSupported(): bool
    {
        return true;
    }

    protected function isBrowserSupported(): bool
    {
        return true;
    }
}
