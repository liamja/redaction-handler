# Monolog Redaction Handler

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

`RedactionHandler` will strip sensitive method/function arguments from stack traces.

## Installation

```bash
$ composer require liamja/redaction-handler
```

## Usage

Wrap any handlers you wish redact with the `RedactionHandler`.

The 2nd argument is an array of function or method names to strip.

```php
$logger = new Logger('foo');
$testHandler = new TestHandler();
$redactionHandler = new RedactionHandler(new TestHandler(), ['checkPassword']);

$logger->pushHandler($redactionHandler);

$password = 'hunter2';
checkPassword($password);  // checkPassword(REDACTED) will appear in the log file.
```

## Changelog

Please see [CHANGELOG.md]() for more information on what has changed recently.

## Testing

```shell
composer test
```

## License

Released under an MIT license.
See [LICENSE.md]() for more info.

[ico-version]: https://img.shields.io/packagist/v/liamja/redaction-handler.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/liamja/redaction-handler/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/liamja/redaction-handler.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/liamja/redaction-handler.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/liamja/redaction-handler.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/liamja/redaction-handler
[link-travis]: https://travis-ci.org/liamja/redaction-handler
[link-scrutinizer]: https://scrutinizer-ci.com/g/liamja/redaction-handler/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/liamja/redaction-handler
[link-downloads]: https://packagist.org/packages/liamja/redaction-handler
[link-author]: https://github.com/liamja
