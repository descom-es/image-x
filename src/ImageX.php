<?php

namespace Descom\ImageX;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;

final class ImageX
{
    private array $validFormats = [
        'avif',
        'webp',
        'jpg',
    ];

    private Image $image;

    public function convert(string $path, string $options): static
    {
        $options = Options::build($options);

        $imageManager = new ImageManager(['driver' => 'gd']);

        $this->image = $imageManager->make($path);

        if ($options->width !== null && $options->height !== null) {
            $this->image = $this->image->resize($options->width, $options->height, function ($constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas($options->width, $options->height, 'center', false, $options->backgroundColor);
        }

        return $this;
    }

    public function response(string $acceptedFormats): mixed
    {
        return $this->image->response();
    }

    public function save(string $path, ?int $quality = null, ?string $format): void
    {
        $this->image->save($path, $quality, $format);
    }


}
