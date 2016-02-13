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

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Parsing\ParserInterface::parse($value)
     */
    public function parse(string $value): string
    {
        $dotPosition = strrpos($value, '.');
        $commaPosition = strrpos($value, ',');
        $separatorPosition = false;

        if ($dotPosition && ($dotPosition > $commaPosition)) {
            $separatorPosition = $dotPosition;
        } elseif ($commaPosition && ($commaPosition > $dotPosition)) {
            $separatorPosition = $commaPosition;
        }

        $regex = '/[^0-9]/';

        if (! $separatorPosition) {
            return (string) intval(preg_replace($regex, '', $value));
        }

        // build the result.
        $result = intval(preg_replace($regex, '', substr($value, 0, $separatorPosition)));
        $fraction = intval(preg_replace($regex, '', substr($value, $separatorPosition + 1)));

        // add the fraction digits only if the value is not 0.
        if ($fraction !== 0) {
            $result .= '.' . $fraction;
        }

        return trim((string) $result, '.');
    }
}
