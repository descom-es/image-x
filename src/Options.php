<?php

namespace Descom\ImageX;

use Descom\ImageX\Options\BackgroundColorOption;
use Descom\ImageX\Options\HeightOption;
use Descom\ImageX\Options\ShortDecode;
use Descom\ImageX\Options\WidthOption;

/**
 * @property ?int $width
 * @property ?int $height
 * @property ?string $backgroundColor
 */
final class Options
{
    private array $options = [
        'width' => WidthOption::class,
        'height' => HeightOption::class,
        'backgroundColor' => BackgroundColorOption::class,
    ];

    private function __construct(string $options)
    {
        $options = ShortDecode::options($options);

        $this->initialize($options);
    }

    /**
     * @param string $options  sample: w_300,h_400,bg_#000000
     */
    public static function build(string $options): self
    {
        return new self($options);
    }

    public function __get(string $option): mixed
    {
        if (isset($this->options[$option])) {
            return $this->options[$option]->value;
        }

        return  null;
    }

    private function initialize(array $options)
    {
        foreach ($this->options as $key => $className) {
            $optionClass = isset($options[$key])
                ? new $className($options[$key])
                : new $className(null);


            $this->options[$key] = $optionClass;
        }
    }
}
