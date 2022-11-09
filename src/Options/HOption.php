<?php

namespace Descom\ImageX\Options;

class HOption extends Option
{
    protected string $name = 'height';

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
