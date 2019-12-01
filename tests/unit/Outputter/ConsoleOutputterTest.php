<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use MikkoTest\ValueObject\Month;
use MikkoTest\ValueObject\PaymentDates;
use MikkoTest\ValueObject\Year;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputterTest extends TestCase
{
    public function test_execute_writesPaymentDatesToConsoleAndReturns0_onSuccessfulOutput()
    {
        $consoleOutputter = new ConsoleOutputter();

        $mockedOutputInterface = $this->createMock(OutputInterface::class);
        $mockedOutputInterface->expects($this->exactly(3))
            ->method('writeln')
            ->withConsecutive(
                array('October,2010-10-29,2010-11-15'),
                array('November,2010-11-30,2010-12-15'),
                array('December,2010-12-31,2011-01-19')
            );

        $paymentDates = array(
            new PaymentDates(new Month(10), new Year('2010')),
            new PaymentDates(new Month(11), new Year('2010')),
            new PaymentDates(new Month(12), new Year('2010'))
        );

        $actualExitCode = $consoleOutputter->execute($paymentDates, $mockedOutputInterface);

        $this->assertSame(
            0,
            $actualExitCode
        );
    }
}
