<?php

namespace Descom\ImageX;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;

final class ImageX
{
    private Image $image;

    private $format = 'jpg';

    public static function default($key, $value): void
    {
        Options::default($key, $value);
    }

    public static function defaults(array $values): void
    {
        Options::defaults($values);
    }

    public static function source(string $path): self
    {
        $imageManager = new ImageManager(['driver' => 'gd']);

        $self = new self();

        $self->image = $imageManager->make($path);

        return $self;
    }

    public function convert(string $options): static
    {
        $options = Options::build($options);

        return $this->resize($options);
    }

    public function response(string $acceptedFormats): mixed
    {
        return $this->image->response();
    }

    public function save(string $path): void
    {
        $this->image->save($path, null, null);
    }

    private function resize(Options $options): static
    {
        if ($options->width === null && $options->height === null) {
            return $this;
        }
        $this->image = $this->image->resize($options->width, $options->height, function ($constraint) {
            $constraint->aspectRatio();
        })->resizeCanvas($options->width, $options->height, 'center', false, $options->backgroundColor);

        return $this;
    }
}
