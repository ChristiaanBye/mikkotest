<?php
declare(strict_types=1);

namespace MikkoTest\ValueObject;

use Carbon\Carbon;
use MikkoTest\Exception\InvalidYearException;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    public function test_constructor_assumesCurrentYear_ifNoYearIsInputted()
    {
        // Let's return to 1999 for this test
        Carbon::setTestNow(Carbon::create(1999, 6, 15));

        $actualObject = new Year(null);

        $expectedObject = new Year('1999');

        $this->assertEquals($expectedObject, $actualObject);

        // ... and we are now back in the present
        Carbon::setTestNow();
    }

    public function test_constructor_setsProvidedYear_ifAYearIsInputted()
    {
        $year = new Year('2015');

        $yearNumberProperty = new \ReflectionProperty(Year::class, 'yearNumber');
        $yearNumberProperty->setAccessible(true);
        $actualValue = $yearNumberProperty->getValue($year);

        $this->assertSame(2015, $actualValue);
    }

    public function test_constructor_throwsInvalidYearException_ifProvidedYearIsNotValid()
    {
        $this->expectException(InvalidYearException::class);
        new Year('invalid');
    }
}
