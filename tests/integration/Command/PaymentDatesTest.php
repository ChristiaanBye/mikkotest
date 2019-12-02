<?php
declare(strict_types=1);

namespace MikkoTest\Tests\Integration\Command;

use Carbon\Carbon;
use MikkoTest\Command\PaymentDates;
use MikkoTest\Outputter\CsvOutputter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @coversNothing
 */
class PaymentDatesTest extends TestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp(): void
    {
        $command = new PaymentDates();

        $this->commandTester = new CommandTester($command);

        // For all tests we will assume the current date in June 1999
        Carbon::setTestNow(Carbon::create(1999, 6, 15));
    }

    protected function tearDown(): void
    {
        // Restore to the present after testing
        Carbon::setTestNow();
    }

    public function test_csvOutput_writesOutputForGivenYear()
    {
        $this->commandTester->execute(
            array(
                '-f' => 'csvOutput_writesOutputForGivenYear.csv',
                '-y' => '2010'
            )
        );

        $this->assertStringContainsString(
            'Outputted payment dates to "output/csvOutput_writesOutputForGivenYear.csv',
            $this->commandTester->getDisplay()
        );

        $this->assertSame(
            file_get_contents(__DIR__ . '/resources/expectedOutput_outputForGivenYear.csv'),
            file_get_contents(CsvOutputter::DEFAULT_OUTPUT_DIRECTORY . 'csvOutput_writesOutputForGivenYear.csv')
        );

        unlink(CsvOutputter::DEFAULT_OUTPUT_DIRECTORY . 'csvOutput_writesOutputForGivenYear.csv');
    }

    public function test_csvOutput_writesOutputForCurrentYear()
    {
        $this->commandTester->execute(
            array(
                '-f' => 'csvOutput_writesOutputForCurrentYear.csv'
            )
        );

        $this->assertStringContainsString(
            'Outputted payment dates to "output/csvOutput_writesOutputForCurrentYear.csv',
            $this->commandTester->getDisplay()
        );

        $this->assertSame(
            file_get_contents(__DIR__ . '/resources/expectedOutput_outputForCurrentYear.csv'),
            file_get_contents(CsvOutputter::DEFAULT_OUTPUT_DIRECTORY . 'csvOutput_writesOutputForCurrentYear.csv')
        );

        unlink(CsvOutputter::DEFAULT_OUTPUT_DIRECTORY . 'csvOutput_writesOutputForCurrentYear.csv');
    }

    public function test_dryRunOutput_providesOutputForGivenYear()
    {
        $this->commandTester->execute(
            array(
                '--year'    => '2010',
                '--dry-run' => true
            )
        );

        $this->assertSame(
            file_get_contents(__DIR__ . '/resources/expectedOutput_outputForGivenYear.csv'),
            $this->commandTester->getDisplay()
        );
    }

    public function test_dryRunOutput_providesOutputForCurrentYear()
    {
        $this->commandTester->execute(
            array(
                '--dry-run' => true
            )
        );

        $this->assertSame(
            file_get_contents(__DIR__ . '/resources/expectedOutput_outputForCurrentYear.csv'),
            $this->commandTester->getDisplay()
        );
    }
}
