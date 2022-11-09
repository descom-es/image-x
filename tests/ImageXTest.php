<?php

namespace Descom\ImageX\Test;

use Descom\ImageX\Http\Header;
use Descom\ImageX\ImageX;
use Descom\ImageX\Options;
use PHPUnit\Framework\TestCase;

class ImageXTest extends TestCase
{
    private string $origen;
    private string $pathTmp;

    public function setUp(): void
    {
        parent::setUp();

        $path = __DIR__.'/stubs';
        $this->origen = $path.'/image.jpg';
        $this->pathTmp = $path.'/tmp';

        if (! file_exists($this->pathTmp)) {
            mkdir($this->pathTmp);
        }

        Options::resets();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // rmdir($this->pathTmp);
    }

    public function testCrop()
    {
        $batchTesting = [
            [
                'options' => 'w_300,h_400',
                'hash' => '293aed1f4b9073cee8851bb689dd9b075415390d45f93260dea2a18e5e1318f7',
            ],
            [
                'options' => 'w_400,h_300',
                'hash' => '71af92a4e02cab38a2586fc920ccda152377835c521138f3353ee6773191db4e',
            ],
            [
                'options' => 'w_600,h_300,b_FF0000',
                'hash' => 'c6ca61d44f7b1f15e45eddfa14e013720e0f4f971c440c2ddfd9acda3db6143f',
            ],
        ];

        foreach ($batchTesting as $testing) {
            $filenameTarget = $this->pathTmp.'/'.str_replace(',', '', $testing['options']).'.jpg';

            ImageX::source($this->origen)
                ->convert($testing['options'])
                ->save($filenameTarget);

            $this->assertEquals($testing['hash'], hash_file('sha256', $filenameTarget));

            unlink($filenameTarget);
        }
    }

    public function testFormatAuto()
    {
        $batchTesting = [
            [
                'options' => 'w_300,h_400',
                'mime' => 'image/jpeg',
                'headers' => [],
            ],
            [
                'options' => 'w_300,h_400,webp',
                'mime' => 'image/webp',
                'headers' => [
                    'accept' => 'image/webp',
                ],
            ],
            [
                'options' => 'w_300,h_400,avif',
                'mime' => 'image/avif',
                'headers' => [
                    'accept' => 'image/avif',
                ],
            ],
        ];

        foreach ($batchTesting as $testing) {
            Header::fake($testing['headers']);

            $filenameTarget = $this->pathTmp.'/'.str_replace(',', '', $testing['options']).'.jpg';

            ImageX::source($this->origen)
                ->convert($testing['options'])
                ->auto()
                ->save($filenameTarget);

            $this->assertEquals($testing['mime'], mime_content_type($filenameTarget));
            unlink($filenameTarget);
        }
    }
}
