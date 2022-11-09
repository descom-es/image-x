<?php

namespace Descom\ImageX\Formats;

use Descom\ImageX\Http\Header;

interface FormatContract
{
    public function extension(): string;
}
