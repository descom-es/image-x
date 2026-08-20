<?php

namespace Descom\ImageX\Test;

use Descom\ImageX\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_option_width()
    {
        $options = Options::build('w_300');

        $this->assertEquals(300, $options->width);
        $this->assertNull($options->height);
        $this->assertEquals('#FFFFFF', $options->backgroundColor);
    }

    public function test_option_height()
    {
        $options = Options::build('h_800');

        $this->assertNull($options->width);
        $this->assertEquals(800, $options->height);
        $this->assertEquals('#FFFFFF', $options->backgroundColor);
    }

    public function test_option_background_color()
    {
        $options = Options::build('bg_F00');

        $this->assertNull($options->width);
        $this->assertNull($options->height);
        $this->assertEquals('#F00', $options->backgroundColor);
    }
}
