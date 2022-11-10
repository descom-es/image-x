# Descom Image-X

[![tests](https://github.com/descom-es/image-x/actions/workflows/tests.yml/badge.svg)](https://github.com/descom-es/image-x/actions/workflows/tests.yml)
[![analyze](https://github.com/descom-es/image-x/actions/workflows/analyze.yml/badge.svg)](https://github.com/descom-es/image-x/actions/workflows/analyze.yml)
[![style](https://github.com/descom-es/image-x/actions/workflows/style_fix.yml/badge.svg)](https://github.com/descom-es/image-x/actions/workflows/style_fix.yml)

Package to PHP to manipulate image to the web.

## Install

Via Composer

```bash
composer require descom/image-x
```

## Usage

```php
use Descom\ImageX\ImageX;

return ImageX::from($filename)
    ->convert('w_200,h_200,bg_000000')
    ->auto() // Auto format to image; webp, jpg
    ->response(); // ->save($otherFilename);
```

## Testing

``` bash
composer test
```
