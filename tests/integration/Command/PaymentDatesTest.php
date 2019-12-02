<?php
declare(strict_types=1);

namespace MikkoTest\Tests\Integration\Command;

use Carbon\Carbon;
use MikkoTest\Command\PaymentDates;
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
            file_get_contents(__DIR__ . '/resources/expectedOutput_dryRunOutput_providesOutputForGivenYear.txt'),
            $this->commandTester->getDisplay()
        );
    }

    public function test_dryRunOutput_providesOutputForCurrentYear()
    {
        // Let's return to June in 1999 for this test
        Carbon::setTestNow(Carbon::create(1999, 6, 15));

        $this->commandTester->execute(
            array(
                '--dry-run' => true
            )
        );

        $this->assertSame(
            file_get_contents(__DIR__ . '/resources/expectedOutput_dryRunOutput_providesOutputForCurrentYear.txt'),
            $this->commandTester->getDisplay()
        );

        // ... and we are now back in the present
        Carbon::setTestNow();
    }
}
