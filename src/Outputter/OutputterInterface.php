<?php

namespace MikkoTest\Outputter;

use Symfony\Component\Console\Output\OutputInterface;

interface OutputterInterface
{
    public function execute(array $paymentDates, OutputInterface $output): void;
}