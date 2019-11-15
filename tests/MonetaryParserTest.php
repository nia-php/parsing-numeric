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

use PHPUnit\Framework\TestCase;
use Nia\Parsing\Numeric\MonetaryParser;

/**
 * Unit test for \Nia\Parsing\Numeric\MonetaryParser.
 */
class MonetaryParserTest extends TestCase
{

    /**
     * @covers \Nia\Parsing\Numeric\MonetaryParser::parse
     *
     * @dataProvider parseProvider
     */
    public function testParse($value, $expected)
    {
        $parser = new MonetaryParser();

        $this->assertSame($expected, $parser->parse($value));
    }

    /**
     * @covers \Nia\Parsing\Numeric\MonetaryParser::parse
     *
     * Tests a really big number (2 KiB)
     */
    public function testReallyLargeNumber()
    {
        $integer = str_repeat('1', 1024);

        $expected = $integer . '.11';
        $value = 'abc' . $expected . 'def';

        $parser = new MonetaryParser();
        $this->assertSame($expected, $parser->parse($value));
    }

    public function parseProvider()
    {
        $content = <<<EOL
Foobar: 123.456.789,12 €;123456789.12
123 456 789,12 \$US;123456789.12
a1b2c3,4.5,1a2;1.00
here-is/no/number;0.00
but-here-are-comma,and.dot;0.00
.12;12.00
0.12;0.12
0.120000;0.12
12.;12.00
0000.0000;0.00
0,00.00,0;0.00
0,,,,,,,1;0.10
1.,,,,.,0;1.00
1,00.00,2;10000.20
;0.00
0.00001;0.00
0.000000000000000000000000000000000000000001;0.00
100000000000000000000000000000000000000000.0;100000000000000000000000000000000000000000.00
0.012345678901234567890123456789012345678901234567890123456789;0.01
12345678901234567890123456789012345678901234567890123456789;12345678901234567890123456789012345678901234567890123456789.00
0.0,001;0.00
0,0.001;0.00
1,2,3,.,4;123.40
   12 , 34 . 56 to 99 . 63;1234.56
this is 12 and 13 more;12.00
price is between 12 and 13 \$US;12.00
EOL;

        // convert CSV to result set
        $result = [];
        foreach (explode("\n", $content) as $line) {
            $result[] = explode(';', $line);
        }

        return $result;
    }
}
