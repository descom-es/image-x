<?php

namespace Descom\ImageX\Test;

use Descom\ImageX\Http\Header;
use Descom\ImageX\ImageX;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class ImageXTest extends TestCase
{
    private string $origen;

    private string $pathTmp;

    protected function setUp(): void
    {
        parent::setUp();

        $path = __DIR__.'/stubs';
        $this->origen = $path.'/image.jpg';
        $this->pathTmp = $path.'/tmp';

        if (! file_exists($this->pathTmp)) {
            mkdir($this->pathTmp);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Header::fake([]);

        if (is_dir($this->pathTmp)) {
            rmdir($this->pathTmp);
        }
    }

    public function test_crop()
    {
        $batchTesting = [
            [
                'options' => 'w_300,h_400',
                'width' => 300,
                'height' => 400,
                'backgroundColor' => 'ffffff',
            ],
            [
                'options' => 'w_400,h_300',
                'width' => 400,
                'height' => 300,
                'backgroundColor' => 'ffffff',
            ],
            [
                'options' => 'w_600,h_300,bg_FF0000',
                'width' => 600,
                'height' => 300,
                'backgroundColor' => 'ff0000',
            ],
        ];

        $manager = new ImageManager(Driver::class);

        foreach ($batchTesting as $testing) {
            $filenameTarget = $this->pathTmp.'/'.str_replace(',', '', $testing['options']).'.jpg';

            ImageX::from($this->origen)
                ->transform($testing['options'])
                ->save($filenameTarget);

            $this->assertEquals('image/jpeg', mime_content_type($filenameTarget));

            $image = $manager->decodePath($filenameTarget);

            $this->assertEquals($testing['width'], $image->width());
            $this->assertEquals($testing['height'], $image->height());
            $this->assertColorMatches($testing['backgroundColor'], $image->colorAt(0, 0)->toHex());

            unlink($filenameTarget);
        }
    }

    public function test_limit()
    {
        $batchTesting = [
            // The stub is 500x500.
            ['transform' => null, 'limit' => 200, 'width' => 200, 'height' => 200],
            ['transform' => null, 'limit' => 1000, 'width' => 500, 'height' => 500],
            ['transform' => 'w_600,h_300', 'limit' => 300, 'width' => 300, 'height' => 150],
            ['transform' => 'w_300,h_600', 'limit' => 300, 'width' => 150, 'height' => 300],
        ];

        $manager = new ImageManager(Driver::class);

        foreach ($batchTesting as $testing) {
            $filenameTarget = $this->pathTmp.'/limit.jpg';

            $image = ImageX::from($this->origen);

            if ($testing['transform'] !== null) {
                $image->transform($testing['transform']);
            }

            $image->limit($testing['limit'])->save($filenameTarget);

            $result = $manager->decodePath($filenameTarget);

            $this->assertEquals($testing['width'], $result->width());
            $this->assertEquals($testing['height'], $result->height());

            unlink($filenameTarget);
        }
    }

    /**
     * JPEG compression is lossy, so a solid background color can shift by a
     * few units per channel (chroma subsampling). Compare with tolerance
     * instead of an exact hex match.
     */
    private function assertColorMatches(string $expectedHex, string $actualHex, int $tolerance = 10): void
    {
        $expected = sscanf($expectedHex, '%02x%02x%02x');
        $actual = sscanf($actualHex, '%02x%02x%02x');

        foreach ($expected as $channel => $value) {
            $this->assertLessThanOrEqual(
                $tolerance,
                abs($value - $actual[$channel]),
                "Channel {$channel} of color {$actualHex} does not match expected {$expectedHex} within tolerance."
            );
        }
    }

    public function test_format_auto()
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
            // [
            //     'options' => 'w_300,h_400,avif',
            //     'mime' => 'image/avif',
            //     'headers' => [
            //         'accept' => 'image/avif',
            //     ],
            // ],
        ];

        foreach ($batchTesting as $testing) {
            Header::fake($testing['headers']);

            $filenameTarget = $this->pathTmp.'/'.str_replace(',', '', $testing['options']).'.jpg';

            ImageX::from($this->origen)
                ->transform($testing['options'])
                ->auto()
                ->save($filenameTarget);

            $this->assertEquals($testing['mime'], mime_content_type($filenameTarget));
            unlink($filenameTarget);
        }
    }
}
