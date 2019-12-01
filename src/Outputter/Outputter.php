<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use MikkoTest\ValueObject\PaymentDates;

class Outputter
{
    protected function generateOutputRow(PaymentDates $paymentDates): array
    {
        return array(
            $paymentDates->getFullTextMonth(),
            $paymentDates->getBasePaymentDate()->format('Y-m-d'),
            $paymentDates->getBonusPaymentDate()->format('Y-m-d')
        );
    }
}