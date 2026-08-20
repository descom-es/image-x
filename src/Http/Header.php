<?php

namespace Descom\ImageX\Http;

final class Header
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

        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        return $this->headersFromServer();
    }

    private function headersFromServer(): array
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headers[str_replace('_', '-', substr($key, 5))] = $value;
            }
        }

        return $headers;
    }

    private function normalizeKey(string $key): string
    {
        return strtr($key, '_ABCDEFGHIJKLMNOPQRSTUVWXYZ', '-abcdefghijklmnopqrstuvwxyz');
    }
}
