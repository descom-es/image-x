<?php

namespace Descom\ImageX\Formats;

use Intervention\Image\Format as InterventionFormat;

final class AvifFormat extends Format
{
    protected string $mimeTypes = 'image/avif';

    protected string $gdInfoKey = 'AVIF Support';

    public function extension(): string
    {
        return 'avif';
    }

    public function interventionFormat(): InterventionFormat
    {
        return InterventionFormat::AVIF;
    }
}
