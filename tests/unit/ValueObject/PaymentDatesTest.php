<?php
declare(strict_types=1);

namespace MikkoTest\ValueObject;

use PHPUnit\Framework\TestCase;

class PaymentDatesTest extends TestCase
{
    public function test_getFullTextMonth_callsMonthObject_toObtainFullTextMonth()
    {
        $mockedMonth = $this->createMock(Month::class);
        $mockedMonth->expects($this->once())
            ->method('getFullTextMonth')
            ->willReturn('Full text month');

        $paymentDates = new PaymentDates($mockedMonth, new Year('2019'));
        $actualValue = $paymentDates->getFullTextMonth();

        $this->assertSame('Full text month', $actualValue);
    }

    /**
     * @dataProvider dataProvider_basePaymentDates
     */
    public function test_getBasePaymentDate_returnsBasePaymentDate(Month $month, Year $year, \DateTimeImmutable $expectedValue)
    {
        $calculator = new PaymentDates($month, $year);

        $this->assertEquals($expectedValue, $calculator->getBasePaymentDate());
    }

    /**
     * @dataProvider dataProvider_bonusPaymentDates
     */
    public function test_getBonusPaymentDate_returnsBonusPaymentDate(Month $month, Year $year, \DateTimeImmutable $expectedValue)
    {
        $calculator = new PaymentDates($month, $year);

        $this->assertEquals($expectedValue, $calculator->getBonusPaymentDate());
    }

    public function dataProvider_basePaymentDates(): array
    {
        return array(
            'lastDayOnSaturday' => array(
                new Month(11),
                new Year('2019'),
                new \DateTimeImmutable('2019-11-29')
            ),
            'lastDayOnSunday' => array(
                new Month(6),
                new Year('2019'),
                new \DateTimeImmutable('2019-06-28')
            ),
            'lastDayOnWeekday' => array(
                new Month(12),
                new Year('2019'),
                new \DateTimeImmutable('2019-12-31')
            )
        );
    }

    public function dataProvider_bonusPaymentDates(): array
    {
        return array(
            'paydayOnSaturday' => array(
                new Month(5),
                new Year('2019'),
                new \DateTimeImmutable('2019-06-19')
            ),
            'paydayOnSunday' => array(
                new Month(11),
                new Year('2019'),
                new \DateTimeImmutable('2019-12-18')
            ),
            'paydayOnWeekday' => array(
                new Month(10),
                new Year('2019'),
                new \DateTimeImmutable('2019-11-15')
            )
        );
    }
}
