# nia - Numeric Parsing Component

This component provides parsers to extract the numeric values of a given value.

## Installation

Require this package with Composer.

```bash
	composer require nia/parsing-numeric
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## How to use
The following sample shows you how to parse a decimal value considering comma and dot positions using the `Nia\Parsing\Numeric\DecimalParser` class.

```php
	$parser = new DecimalParser();
	echo $parser->parse('Price: 123 456 789,12 $US'); // 123456789.12
	echo $parser->parse('12,2'); // 12.2
	echo $parser->parse('1.234.5'); // 1234.5
	echo $parser->parse('1.234,5'); // 1234,5
```

## Notice
The parser is also able to handle large numbers (tested with strings over 2 MiB)
