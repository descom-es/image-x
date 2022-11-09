<?php

namespace Descom\ImageX\Options;

/**
 * @property string $name
 * @property mixed $value
 */
abstract class Option
{
    protected string $name = '';
    protected mixed $value = null;

    public function __get($name)
    {
        if ($name === 'value') {
            return $this->value ?? null;
        }

        if ($name === 'name') {
            return $this->name;
        }

        throw new \Exception("Property {$name} does not exist");
    }
}
