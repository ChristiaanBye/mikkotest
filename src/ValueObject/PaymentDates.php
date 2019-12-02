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
        return $this->month->getFullTextMonth();
    }

    /**
     * Returns the base payment date by using the following rule: "The base salaries are paid on the last day of the
     * month unless that day is a Saturday or a Sunday (weekend).
     *
     * In the flowchart it states that when the last day of the month is a Saturday or Sunday the payment is made on the
     * last weekday of the month instead.
     *
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    public function getBasePaymentDate(): \DateTimeImmutable
    {
        $paymentDate = new \DateTime(
            $this->year->getYearNumber() . '-' .
            $this->month->getNumericMonth() . '-' .
            $this->getLastDayOfMonth($this->month, $this->year->getYearNumber())
        );

        while ($this->isWeekend($paymentDate)) {
            $paymentDate->sub(new \DateInterval('P1D'));
        }

        return \DateTimeImmutable::createFromMutable($paymentDate);
    }

    /**
     * Returns the bonus payment date by using the following rule: "On the 15th of every month bonuses are paid for the
     * previous month, unless that day is a weekend. In that case, they are paid the first Wednesday after the 15th."
     *
     * @return \DateTimeImmutable
     * @throws \Exception
     */
    public function getBonusPaymentDate(): \DateTimeImmutable
    {
        $paymentDate = new \DateTime(
            $this->year->getYearNumber() . '-' .
            $this->month->getNumericMonth() . '-' .
            15
        );

        $paymentDate->add(new \DateInterval('P1M'));

        if ($this->isWeekend($paymentDate)) {
            while (!$this->isWednesday($paymentDate)) {
                $paymentDate->add(new \DateInterval('P1D'));
            }
        }

        return \DateTimeImmutable::createFromMutable($paymentDate);
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    private function isWednesday(\DateTime $dateTime): bool
    {
        if ((int)$dateTime->format('N') === 3) {
            return true;
        }

        return false;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    private function isWeekend(\DateTime $dateTime): bool
    {
        if ((int)$dateTime->format('N') > 5) {
            return true;
        }

        return false;
    }

    /**
     * @param Month $month
     * @param int   $year
     *
     * @return int
     * @throws \Exception
     */
    private function getLastDayOfMonth(Month $month, int $year): int
    {
        $dateTime = new \DateTime(
            $year . '-' .
            $month->getNumericMonth() . '-' .
            1
        );

        return (int)$dateTime->format('t');
    }
}