<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputter implements OutputterInterface
{
    public function execute(array $paymentDates, OutputInterface $output): int
    {
        foreach ($paymentDates as $paymentDate) {
            $output->writeln(implode(',', array(
                $paymentDate->getFullTextMonth(),
                $paymentDate->getBasePaymentDate()->format('Y-m-d'),
                $paymentDate->getBonusPaymentDate()->format('Y-m-d')
            )));
        }

        return 0;
    }
}