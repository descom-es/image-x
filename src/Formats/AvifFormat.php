<?php

namespace Descom\ImageX\Formats;

final class AvifFormat extends Format
{
    protected string $mimeTypes = 'image/avif';

    protected string $gdInfoKey = 'AVIF Support';

    public function extension(): string
    {
        return 'avif';
    }
}
