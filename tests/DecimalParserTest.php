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
namespace Test\Nia\Parsing\Numeric;

use PHPUnit_Framework_TestCase;
use Nia\Parsing\Numeric\DecimalParser;

/**
 * Unit test for \Nia\Parsing\Numeric\DecimalParser.
 */
class DecimalParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Parsing\Numeric\DecimalParser::parse
     *
     * @dataProvider parseProvider
     */
    public function testParse($value, $expected)
    {
        $parser = new DecimalParser($value);

        $this->assertSame($expected, $parser->parse($value));
    }

    public function parseProvider()
    {
        $content = <<<EOL
Foobar: 123.456.789,12 €;123456789.12
123 456 789,12 \$US;123456789.12
a1b2c3,4.5,1a2;12345.12
here-is/no/number;0
but-here-are-comma,and.dot;0
.12;12
0.12;0.12
12.;12
0000.0000;0
0,00.00,0;0
0,,,,,,,1;0.1
1.,,,,.,0;1
1,00.00,2;10000.2
;0
EOL;

        // convert CSV to result set
        $result = [];
        foreach (explode("\n", $content) as $line) {
            $result[] = explode(';', $line);
        }

        return $result;
    }
}