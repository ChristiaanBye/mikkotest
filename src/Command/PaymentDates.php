<?php
declare(strict_types=1);

namespace MikkoTest\Command;

use MikkoTest\Factory\OutputterFactory;
use MikkoTest\Factory\PaymentDatesFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PaymentDates extends Command
{
    protected function configure()
    {
        $this->setName('payment-dates:generate')
            ->setDescription('Generates a .csv file containing the payment dates for the sales staff')
            ->addOption(
                'filename',
                'f',
                InputOption::VALUE_OPTIONAL,
                'The file name of the outputted .csv file'
            )
            ->addOption(
                'year',
                'y',
                InputOption::VALUE_OPTIONAL,
                'Provide a year to calculate payment dates for. If no date was provided, dates are generated for the remainder of the current year'
            )
            ->addOption(
                'dry-run'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $paymentDates = PaymentDatesFactory::createPaymentDates($input);
        $outputter    = OutputterFactory::createOutputter($input);

        return $outputter->execute($paymentDates, $output);
    }
}