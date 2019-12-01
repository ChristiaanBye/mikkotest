<?php
declare(strict_types=1);

namespace MikkoTest\Factory;

use MikkoTest\Outputter\ConsoleOutputter;
use MikkoTest\Outputter\CsvOutputter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

class OutputterFactoryTest extends TestCase
{
    public function test_createOutputter_createsConsoleOutputter_whenDryRunIsRequested()
    {
        $mockedInput = $this->createMock(InputInterface::class);
        $mockedInput->expects($this->once())
            ->method('getOption')
            ->with('dry-run')
            ->willReturn(true);

        $this->assertInstanceOf(
            ConsoleOutputter::class,
            OutputterFactory::createOutputter($mockedInput)
        );
    }

    public function test_createOutputter_createsCsvOutputter_whenDryRunIsNotRequested()
    {
        $mockedInput = $this->createMock(InputInterface::class);
        $mockedInput->expects($this->exactly(2))
            ->method('getOption')
            ->willReturnMap(array(
                array(
                    'dry-run', // $name
                    null       // return value
                ),
                array(
                    'filename', // $name
                    'File Name' // return value
                )
            ));

        $this->assertInstanceOf(
            CsvOutputter::class,
            OutputterFactory::createOutputter($mockedInput)
        );
    }
}
