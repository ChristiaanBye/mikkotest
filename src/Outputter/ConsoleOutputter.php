<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputter extends Outputter implements OutputterInterface
{
    public function execute(array $paymentDates, OutputInterface $output): int
    {
        foreach ($paymentDates as $paymentDate) {
            $output->writeln(implode(',', $this->generateOutputRow($paymentDate)));
        }

        return 0;
    }
}