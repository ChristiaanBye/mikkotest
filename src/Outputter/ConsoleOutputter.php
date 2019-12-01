<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputter implements OutputterInterface
{
    public function execute(array $paymentDates, OutputInterface $output): int
    {
        // TODO: Implement execute() method.
    }
}