<?php
declare(strict_types=1);

namespace MikkoTest\Factory;

use Carbon\Carbon;
use MikkoTest\ValueObject\Month;
use MikkoTest\ValueObject\PaymentDates;
use MikkoTest\ValueObject\Year;
use Symfony\Component\Console\Input\InputInterface;

class PaymentDatesFactory
{
    /**
     * @param InputInterface $input
     *
     * @return array
     */
    public static function createPaymentDates(InputInterface $input): array
    {
        $payments      = array();
        $startingMonth = 1;
        $year          = $input->getOption('year');

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