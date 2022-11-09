<?php

namespace Descom\ImageX\Test;

use Descom\ImageX\Http\Header;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testHHeader()
    {
        $batchTesting = [
            'accept' => '123456789',
            'Accept' => '01233456789',
        ];

        foreach ($batchTesting as $key => $value) {
            $header = new Header();
            $header->set('accept', $value);
            $this->assertEquals($value, $header->get('accept'));
        }
    }
}
