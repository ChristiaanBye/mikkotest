<?php
declare(strict_types=1);

namespace MikkoTest\Factory;

use MikkoTest\Outputter\ConsoleOutputter;
use MikkoTest\Outputter\CsvOutputter;
use MikkoTest\Outputter\OutputterInterface;
use Symfony\Component\Console\Input\InputInterface;

class OutputterFactory
{
    public static function createOutputter(InputInterface $input): OutputterInterface
    {
        if ($input->getOption('dry-run') === true) {
            return new ConsoleOutputter();
        }

        return new CsvOutputter(CsvOutputter::DEFAULT_OUTPUT_DIRECTORY, $input->getOption('filename'));
    }
}