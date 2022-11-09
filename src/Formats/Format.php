<?php

namespace Descom\ImageX\Formats;

use Descom\ImageX\Http\Header;

abstract class Format
{
    protected string $mimeTypes = 'image/unknown';
    protected string $gdInfoKey = 'unknown';

    abstract public function extension(): string;

    public function isSupported(): bool
    {
        return $this->isBrowserSupported() && $this->isServerSupported();
    }

    protected function isServerSupported(): bool
    {
        return gd_info()[$this->gdInfoKey];
    }

    protected function isBrowserSupported(): bool
    {
        $headers = new Header();

        $accept = $headers->get('accept', '');

        return $this->isBrowserSupportedByAccept($accept);
    }

    private function isBrowserSupportedByAccept(string $accept): bool
    {
        $accept = explode(',', $accept);

        foreach ($accept as $item) {
            $item = explode(';', $item);

            if (trim($item[0]) === $this->mimeTypes) {
                return true;
            }
        }

        return false;
    }
}
