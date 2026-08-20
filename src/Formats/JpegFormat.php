<?php

namespace Descom\ImageX\Formats;

use Intervention\Image\Format as InterventionFormat;

final class JpegFormat extends Format
{
    protected string $mimeTypes = 'image/jpeg';

    protected string $gdInfoKey = 'JPEG Support';

    public function extension(): string
    {
        return 'jpg';
    }

    public function interventionFormat(): InterventionFormat
    {
        return InterventionFormat::JPEG;
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
