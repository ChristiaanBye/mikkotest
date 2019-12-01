<?php
declare(strict_types=1);

namespace MikkoTest\Factory;

use Carbon\Carbon;
use MikkoTest\ValueObject\Month;
use MikkoTest\ValueObject\PaymentDates;
use MikkoTest\ValueObject\Year;
use PHPUnit\Framework\TestCase;

class PaymentDatesFactoryTest extends TestCase
{
    public function test_generatePaymentDates_generatesPaymentDatesObjectsForRemainderOfCurrentYear_ifNullIsPassed()
    {
        // Let's return to June in 1999 for this test
        Carbon::setTestNow(Carbon::create(1999, 6, 15));

        $factory  = new PaymentDatesFactory();
        $paymentDates = $factory->generatePaymentDates(null);

        $expectedResult = array(
            new PaymentDates(new Month(6),  new Year('1999')),
            new PaymentDates(new Month(7),  new Year('1999')),
            new PaymentDates(new Month(8),  new Year('1999')),
            new PaymentDates(new Month(9),  new Year('1999')),
            new PaymentDates(new Month(10), new Year('1999')),
            new PaymentDates(new Month(11), new Year('1999')),
            new PaymentDates(new Month(12), new Year('1999'))
        );

        $this->assertEquals($expectedResult, $paymentDates);

        // ... and we are now back in the present
        Carbon::setTestNow();
    }

    public function test_generatePaymentDates_generatesPaymentDatesObjectsForFullYear_ifAYearIsPassed()
    {
        $factory  = new PaymentDatesFactory();
        $paymentDates = $factory->generatePaymentDates('2021');

        $expectedResult = array(
            new PaymentDates(new Month(1),  new Year('2021')),
            new PaymentDates(new Month(2),  new Year('2021')),
            new PaymentDates(new Month(3),  new Year('2021')),
            new PaymentDates(new Month(4),  new Year('2021')),
            new PaymentDates(new Month(5),  new Year('2021')),
            new PaymentDates(new Month(6),  new Year('2021')),
            new PaymentDates(new Month(7),  new Year('2021')),
            new PaymentDates(new Month(8),  new Year('2021')),
            new PaymentDates(new Month(9),  new Year('2021')),
            new PaymentDates(new Month(10), new Year('2021')),
            new PaymentDates(new Month(11), new Year('2021')),
            new PaymentDates(new Month(12), new Year('2021'))
        );

        $this->assertEquals($expectedResult, $paymentDates);
    }
}
