<?php

namespace Descom\ImageXTest\Test;

use Descom\ImageX\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Options::resets();
    }

    public function testDefaultValues()
    {
        $options = Options::build('');
        $this->assertNull( $options->width);
        $this->assertNull($options->height);
        $this->assertEquals('#FFFFFF', $options->backgroundColor);

        Options::defaults([
            'width' => 300,
            'height' => 400,
            'backgroundColor' => '#F00',
        ]);;
        $options = Options::build('');

        $this->assertEquals(300, $options->width);
        $this->assertEquals(400, $options->height);
        $this->assertEquals('#F00', $options->backgroundColor);
    }

    public function testOptionWidth()
    {
        $options = Options::build('w_300');

        $this->assertEquals(300, $options->width);
        $this->assertNull($options->height);
        $this->assertEquals('#FFFFFF', $options->backgroundColor);
    }

    public function testOptionHeight()
    {
        $options = Options::build('h_800');

        $this->assertNull($options->width);
        $this->assertEquals(800, $options->height);
        $this->assertEquals('#FFFFFF', $options->backgroundColor);
    }

    public function testOptionBackgroundColor()
    {
        $options = Options::build('b_F00');

        $this->assertNull($options->width);
        $this->assertNull($options->height);
        $this->assertEquals('#F00', $options->backgroundColor);
    }
}
