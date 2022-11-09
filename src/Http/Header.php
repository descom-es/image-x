<?php

namespace Descom\ImageX\Http;

class Header
{
    private array $headers = [];

    public function __construct()
    {
        $headers = [];
        $headersOriginal = getallheaders();

        array_walk(
            $headersOriginal,
            function (&$value, $key) use (&$headers) {
                $key = strtr($key, '_ABCDEFGHIJKLMNOPQRSTUVWXYZ', '-abcdefghijklmnopqrstuvwxyz');

                $headers[$key] = $item;
            }
        );

        $this->headers = $headers;
    }

    public function set(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $this->headers[$this->normalizeKey($key)] ?? $default;
    }

    private function normalizeKey(string $key): string
    {
        return strtr($key, '_ABCDEFGHIJKLMNOPQRSTUVWXYZ', '-abcdefghijklmnopqrstuvwxyz');
    }
}
