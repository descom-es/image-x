<?php

namespace Descom\ImageX\Formats;

final class WebpFormat extends Format
{
    protected string $mimeTypes = 'image/webp';

    protected string $gdInfoKey = 'WebP Support';

    public function extension(): string
    {
        return 'webp';
    }
}
