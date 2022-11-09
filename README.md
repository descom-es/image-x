# Descom Image-X

[![tests](https://github.com/descom-es/image-x/actions/workflows/tests.yml/badge.svg)](https://github.com/descom-es/image-x/actions/workflows/tests.yml)
[![analyze](https://github.com/descom-es/image-x/actions/workflows/analyze.yml/badge.svg)](https://github.com/descom-es/image-x/actions/workflows/analyze.yml)
[![style](https://github.com/descom-es/image-x/actions/workflows/style_fix.yml/badge.svg)](https://github.com/descom-es/image-x/actions/workflows/style_fix.yml)

Package to PHP to manipulate image to the web.

## Install

Via Composer

```bash
composer require descom/package_name
```

## Usage

```php
use Descom\ImageX\ImageX;

// Optional
ImageX::defaults([
    'width' => 100, // Default null, original width
    'height' => 100, // Default null, original height
    'backgroundColor' => 'F5F5F5', // Default FFFFFF
]);

$imageX = new ImageX();

return ImageX::from($filename)
    ->convert('w_200,h_200,b_000000')
    ->auto() // Auto format to image; avif, webp, jpg
    ->stream(); // ->save($otherFilename);
```

## Testing

``` bash
composer test
```
