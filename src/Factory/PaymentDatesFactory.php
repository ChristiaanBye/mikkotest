<?php
declare(strict_types=1);

namespace MikkoTest\Factory;

use Carbon\Carbon;
use MikkoTest\ValueObject\Month;
use MikkoTest\ValueObject\PaymentDates;
use MikkoTest\ValueObject\Year;

class PaymentDatesFactory
{
    /**
     * @param string|null $year
     *
     * @return array
     */
    public static function createPaymentDates(?string $year): array
    {
        $payments      = array();
        $startingMonth = 1;

        // If the year was not provided, we only provide the payment dates for the remainder of the year
        if ($year === null) {
            $startingMonth = (int)Carbon::now()->format('m');
        }

        $currentMonth = $startingMonth;
        while ($currentMonth <= 12) {
            $payments[] = new PaymentDates(new Month($currentMonth), new Year($year));

            $currentMonth++;
        }

        return $payments;
    }
}