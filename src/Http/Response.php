<?php

namespace Descom\ImageX\Http;

use Intervention\Image\Interfaces\EncodedImageInterface;

final class Response
{
    /**
     * Builds an HTTP response from an already encoded image, using
     * Laravel or Symfony's response classes when available, falling
     * back to raw headers otherwise.
     */
    public static function make(EncodedImageInterface $encoded): mixed
    {
        $data = $encoded->toString();
        $mime = $encoded->mediaType();
        $length = strlen($data);

        $illuminateResponse = 'Illuminate\Support\Facades\Response';

        if (function_exists('app') && is_a(app(), 'Illuminate\Foundation\Application') && class_exists($illuminateResponse)) {
            $response = $illuminateResponse::make($data);
            $response->header('Content-Type', $mime);
            $response->header('Content-Length', $length);

            return $response;
        }

        $symfonyResponse = 'Symfony\Component\HttpFoundation\Response';

        if (class_exists($symfonyResponse)) {
            $response = new $symfonyResponse($data);
            $response->headers->set('Content-Type', $mime);
            $response->headers->set('Content-Length', (string) $length);

            return $response;
        }

        header('Content-Type: '.$mime);
        header('Content-Length: '.$length);

        return $data;
    }
}
