<?php

namespace Descom\ImageX;

use Descom\ImageX\Formats\Auto;
use Descom\ImageX\Formats\Format;
use Descom\ImageX\Formats\JpgFormat;
use Descom\ImageX\Http\Response;
use Intervention\Image\Alignment;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Intervention\Image\Interfaces\ImageInterface;

final class ImageX
{
    private const int QUALITY = 90;

    private ImageInterface $image;

    private ?Format $format = null;

    private function __construct()
    {
        $this->format = new JpgFormat;
    }

    public static function from(string $path, string $driver = 'gd'): self
    {
        $imageManager = new ImageManager(self::resolveDriver($driver));

        $self = new self;

        $self->image = $imageManager->decodePath($path);

        return $self;
    }

    public function auto(): self
    {
        $this->format = (new Auto)->detect();

        return $this;
    }

    public function transform(string $options): static
    {
        $options = Options::build($options);

        return $this->resize($options);
    }

    public function response(): mixed
    {
        return Response::make($this->encode());
    }

    public function save(string $path): void
    {
        $this->encode()->save($path);
    }

    private static function resolveDriver(string $driver): string
    {
        return match ($driver) {
            'gd' => GdDriver::class,
            'imagick' => ImagickDriver::class,
            default => $driver,
        };
    }

    private function encode(): EncodedImageInterface
    {
        return $this->image->encode($this->format->encoder(self::QUALITY));
    }

    private function resize(Options $options): static
    {
        if ($options->width === null && $options->height === null) {
            return $this;
        }

        $this->image = $this->image
            ->scale($options->width, $options->height)
            ->resizeCanvas($options->width, $options->height, $options->backgroundColor, Alignment::CENTER);

        return $this;
    }
}
