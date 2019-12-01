<?php
declare(strict_types=1);

namespace MikkoTest\ValueObject;

class PaymentDates
{
    /**
     * @var Month
     */
    private $month;

    /**
     * @var Year
     */
    private $year;

    public function __construct(Month $month, Year $year)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    /**
     * return string
     */
    public function getFullTextMonth(): string
    {

    }

    /**
     * Returns the base payment date by using the following rule: "The base salaries are paid on the last day of the
     * month unless that day is a Saturday or a Sunday (weekend).
     *
     * As the specification doesn't state what should happen if the last day is on the weekend, I have assumed the last
     * weekday in these cases.
     *
     * @return \DateTimeImmutable
     */
    public function getBasePaymentDate(): \DateTimeImmutable
    {

    }

    /**
     * Returns the bonus payment date by using the following rule: "On the 15th of every month bonuses are paid for the
     * previous month, unless that day is a weekend. In that case, they are paid the first Wednesday after the 15th."
     *
     * @return \DateTimeImmutable
     */
    public function getBonusPaymentDate(): \DateTimeImmutable
    {

    }
}