<?php

namespace Descom\ImageX;

/**
 * @property ?int $width
 * @property ?int $height
 * @property ?string $backgroundColor
 */
final class Options
{
    private array $options = [
        'width' => null,
        'height' => null,
        'backgroundColor' => null,
    ];

    private static $defaultsValue = [
        'backgroundColor' => '#FFFFFF',
    ];

    private function __construct(string $options)
    {
        $this->decode($options);
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
        return $this->options[$option]
            ?? static::$defaultsValue[$option]
            ?? null;
    }

    public static function default($key, $value): void
    {
        $className = static::classOption($key);

        if (class_exists($className)) {
            static::$defaultsValue[$key] = $value;
        }
    }

    public static function defaults(array $values): void
    {
        foreach ($values as $key => $value) {
            static::default($key, $value);
        }
    }

    public static function resets(): void
    {
        static::$defaultsValue = [
            'backgroundColor' => '#FFFFFF',
        ];
    }

    private function decode(string $options): void
    {
        $options = explode(',', $options);

        foreach ($options as $option) {
            $option = explode('_', $option);

            if (count($option) === 2) {
                $key = $option[0];
                $value = $option[1];

                $className = static::classOption($key);
                if (class_exists($className)) {
                    $class = new $className($value);
                    $this->options[$class->name] = $class->value;
                }
            }
        }
    }

    private static function classOption(string $key): string
    {
        return 'Descom\\ImageX\\Options\\' . ucfirst($key[0]) . 'Option';
    }
}
