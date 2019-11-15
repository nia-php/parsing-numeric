<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Nia\Parsing\Numeric;

use Nia\Parsing\ParserInterface;

/**
 * Parses a monetary value from a given value.
 */
class MonetaryParser implements ParserInterface
{

    public function parse(string $value): string
    {
        $parser = new DecimalParser();

        $value = $parser->parse($value);

        list($integer, $fraction) = explode('.', $value, 2) + array_fill(0, 2, '');
        $fraction .= '00';
        $fraction = substr($fraction, 0, 2);

        return $integer . '.' . $fraction;
    }
}

