<?php

namespace Descom\ImageX\Formats;

final class Auto
{
    public static function detect(): Format
    {
        // $format = new AvifFormat();

        // if ($format->isSupported()) {
        //     return new AvifFormat();
        // }

        $format = new WebpFormat();

        if ($format->isSupported()) {
            return new WebpFormat();
        }

        return new JpgFormat();
    }
}
