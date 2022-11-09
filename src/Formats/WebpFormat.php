<?php

namespace Descom\ImageX\Formats;

use Descom\ImageX\Http\Header;

final class WebpFormat extends Format implements FormatContract
{
    protected string $mimeTypes = 'image/webp';

    protected string $gdInfoKey = 'WebP Support';

    public function extension(): string
    {
        return 'webp';
    }
}
