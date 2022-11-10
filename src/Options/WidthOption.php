<?php

namespace Descom\ImageX\Options;

class WidthOption extends Option
{
    protected string $name = 'width';

    public function __construct(?string $value)
    {
        $this->value = $value;

        if ($this->value === null) {
            return;
        }

        $this->value = (int) $this->value;

        if ($this->value <= 0) {
            throw new \InvalidArgumentException("{$this->name} must be greater than 0");
        }
    }
}
