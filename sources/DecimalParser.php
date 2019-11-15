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
 * Parses a decimal value from a given value.
 */
class DecimalParser implements ParserInterface
{

    public function parse(string $value): string
    {
        $value = preg_replace('/^[^0-9,.]+/', '', $value);
        list($value) = preg_split('/[^0-9,.\x{00a0} ]/u', $value);

        $value = str_replace(',', '.', $value);
        $value = preg_replace('/[^0-9.]/', '', $value);
        $value = preg_replace('/\.(?=.*?\.)/', '', $value);
        $value = trim($value, '.');

        list ($integer, $fraction) = explode('.', $value) + array_fill(0, 2, '');

        $integer = ltrim($integer, '0');

        if ($integer === '') {
            $integer = '0';
        }

        if (trim($fraction, '0') !== '') {
            return $integer . '.' . rtrim($fraction, '0');
        }

        return (string) $integer;
    }
}
