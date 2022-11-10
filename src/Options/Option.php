<?php

namespace Descom\ImageX\Options;

use Closure;

/**
 * @property string $name
 * @property mixed $value
 */
abstract class Option
{
    protected string $name = '';
    protected mixed $value = null;
    protected static ?Closure $defaultValue = null;

    public function __get($name): mixed
    {
        if ($name === 'value') {
            return $this->value ?? $this->resolveDefaultValue();
        }

        if ($name === 'name') {
            return $this->name;
        }

        throw new \Exception("Property {$name} does not exist");
    }

    private function resolveDefaultValue(): mixed
    {
        if (is_null(static::$defaultValue)) {
            return null;
        }

        $call = static::$defaultValue;

        return $call();
    }
}
