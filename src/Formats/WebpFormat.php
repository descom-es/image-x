<?php

namespace Descom\ImageX\Formats;

use Intervention\Image\Format as InterventionFormat;

final class WebpFormat extends Format
{
    protected string $mimeTypes = 'image/webp';

    protected string $gdInfoKey = 'WebP Support';

    public function extension(): string
    {
        return 'webp';
    }

    public function interventionFormat(): InterventionFormat
    {
        return InterventionFormat::WEBP;
    }
}
