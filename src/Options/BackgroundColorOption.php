<?php

namespace Descom\ImageX\Options;

use Closure;

class BackgroundColorOption extends Option
{
    protected string $name = 'backgroundColor';

    protected static ?Closure $defaultValue = null;

    public function __construct(?string $value)
    {
        static::$defaultValue = fn () => '#FFFFFF';

        $this->value = $value;

        if ($this->value === null) {
            return;
        }

        $this->value = '#'.$this->value;
    }
}
