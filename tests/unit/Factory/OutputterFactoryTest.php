<?php

namespace MikkoTest\Factory;

use MikkoTest\Outputter\ConsoleOutputter;
use MikkoTest\Outputter\CsvOutputter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

class OutputterFactoryTest extends TestCase
{
    public function test_createOutputter_createsConsoleOutputter_whenDryRunIsRequested()
    {
        $mockedInput = $this->createMockedInput(true);

        $outputterFactory = new OutputterFactory();
        $actualObject = $outputterFactory->createOutputter($mockedInput);

        $this->assertInstanceOf(ConsoleOutputter::class, $actualObject);
    }

    public function test_createOutputter_createsCsvOutputter_whenDryRunIsNotRequested()
    {
        $mockedInput = $this->createMockedInput(null);

        $outputterFactory = new OutputterFactory();
        $actualObject = $outputterFactory->createOutputter($mockedInput);

        $this->assertInstanceOf(CsvOutputter::class, $actualObject);
    }

    /**
     * @param bool|null $returnValue
     *
     * @return MockObject|InputInterface
     */
    private function createMockedInput(?bool $returnValue): MockObject
    {
        $mockedInput = $this->createMock(InputInterface::class);
        $mockedInput->expects($this->once())
            ->method('getOption')
            ->with('dry-run')
            ->willReturn($returnValue);

        return $mockedInput;
    }
}
