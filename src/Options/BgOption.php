<?php

namespace Descom\ImageX\Options;

class BgOption extends Option
{
    protected string $name = 'backgroundColor';

    public function __construct(?string $value)
    {
        $this->value = $value;

        if ($this->value === null) {
            return;
        }

        $this->value = '#'.$this->value;
    }
}
