<?php

namespace Descom\ImageX;

use Descom\ImageX\Formats\Auto;
use Descom\ImageX\Formats\Format;
use Descom\ImageX\Formats\JpgFormat;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

final class ImageX
{
    private Image $image;

    private ?Format $format = null;

    private function __construct()
    {
        $this->format = new JpgFormat();
    }

    public static function from(string $path): self
    {
        $imageManager = new ImageManager(['driver' => 'gd']);

        $self = new self();

        $self->image = $imageManager->make($path);

        return $self;
    }

    public function auto(): self
    {
        $this->format = (new Auto())->detect();

        return $this;
    }

    public function transform(string $options): static
    {
        $options = Options::build($options);

        return $this->resize($options);
    }

    public function response(string $acceptedFormats): mixed
    {
        return $this->image->response($this->format->extension());
    }

    public function save(string $path): void
    {
        $this->image->save($path, null, $this->format->extension());
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
