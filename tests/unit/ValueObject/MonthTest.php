<?php
declare(strict_types=1);

namespace MikkoTest\ValueObject;

use MikkoTest\Exception\InvalidMonthException;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function test_constructor_throwsInvalidMonthException_whenInputtedMonthIsLessThan1()
    {
        $this->expectException(InvalidMonthException::class);
        new Month(rand(-1000, 0));
    }

    public function test_constructor_throwsInvalidMonthException_whenInputtedMonthIsGreaterThan12()
    {
        $this->expectException(InvalidMonthException::class);
        new Month(rand(13, 1000));
    }

    /**
     * @dataProvider dataProvider_fullTextMonths
     */
    public function test_getFullTextMonth_returnsAFullTextRepresentationOfAMonthInEnglish(int $month, string $expectedValue)
    {
        $monthObject = new Month($month);

        $this->assertSame($expectedValue, $monthObject->getFullTextMonth());
    }

    public function test_getFullTextMonth_throwsInvalidMonthException_whenInputtedMonthIsInvalid()
    {
        $month = new Month(rand(1, 12));

        $monthProperty = new \ReflectionProperty(Month::class, 'month');
        $monthProperty->setAccessible(true);
        $monthProperty->setValue($month, 1337);

        $this->expectException(InvalidMonthException::class);
        $month->getFullTextMonth();
    }

    public function test_getNumericMonth_returnsTheSameValueUsedToInstantiateObject()
    {
        $expectedValue = rand(1, 12);

        $month = new Month($expectedValue);

        $this->assertSame($expectedValue, $month->getNumericMonth());
    }

    public function dataProvider_fullTextMonths(): array
    {
        return array(
            'January' => array(
                1,        // $month
                'January' // $expectedValue
            ),
            'February' => array(
                2,
                'February'
            ),
            'March' => array(
                3,
                'March'
            ),
            'April' => array(
                4,
                'April'
            ),
            'May' => array(
                5,
                'May'
            ),
            'June' => array(
                6,
                'June'
            ),
            'July' => array(
                7,
                'July'
            ),
            'August' => array(
                8,
                'August'
            ),
            'September' => array(
                9,
                'September'
            ),
            'October' => array(
                10,
                'October'
            ),
            'November' => array(
                11,
                'November'
            ),
            'December' => array(
                12,
                'December'
            )
        );
    }
}
