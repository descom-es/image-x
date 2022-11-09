<?php

namespace Descom\ImageX\Http;

class Header
{
    private array $headers = [];

    private static array $fakeHeaders = [];

    public function __construct()
    {
        $headers = [];
        $headersOriginal = $this->headers();

        array_walk(
            $headersOriginal,
            function (&$value, $key) use (&$headers) {
                $key = strtr($key, '_ABCDEFGHIJKLMNOPQRSTUVWXYZ', '-abcdefghijklmnopqrstuvwxyz');

                $headers[$key] = $value;
            }
        );

        $this->headers = $headers;
    }

    public static function fake(array $headers): void
    {
        self::$fakeHeaders = $headers;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $this->headers[$this->normalizeKey($key)] ?? $default;
    }

    private function headers(): array
    {
        if (static::$fakeHeaders) {
            return static::$fakeHeaders;
        }

        return getallheaders();
    }

    private function normalizeKey(string $key): string
    {
        return strtr($key, '_ABCDEFGHIJKLMNOPQRSTUVWXYZ', '-abcdefghijklmnopqrstuvwxyz');
    }
}
