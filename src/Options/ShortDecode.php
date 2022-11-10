<?php

namespace Descom\ImageX\Options;

class ShortDecode
{
    private array $allowedOptions = [
        'w' => 'width',
        'h' => 'height',
        'bg' => 'backgroundColor',
    ];

    public static function options(string $options): array
    {
        $self = new self();

        return $self->decodeString($options);
    }

    private function decodeString(string $options): array
    {
        $decoded = [];

        $options = explode(',', $options);

        foreach ($options as $option) {
            $option = explode('_', $option);

            if (count($option) === 2 && isset($this->allowedOptions[$option[0]])) {
                $decoded[$this->allowedOptions[$option[0]]] = $option[1];
            }
        }

        return $decoded;
    }
}
