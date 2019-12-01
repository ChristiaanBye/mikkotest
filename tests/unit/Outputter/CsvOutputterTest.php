<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use MikkoTest\Exception\InvalidFileNameException;
use MikkoTest\Exception\UnableToCreateDirectoryException;
use MikkoTest\Exception\UnableToWriteFileException;
use MikkoTest\ValueObject\Month;
use MikkoTest\ValueObject\PaymentDates;
use MikkoTest\ValueObject\Year;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CsvOutputterTest extends TestCase
{
    /**
     * @dataProvider dataProvider_emptyFileNames
     */
    public function test_constructor_throwsInvalidFileNameException_ifFileNameIsNotProvided($emptyFileName)
    {
        $this->expectException(InvalidFileNameException::class);
        new CsvOutputter(vfsStream::setup()->url(), $emptyFileName);
    }

    public function test_execute_writesOutputToCsvAndReturns0_onSuccessfulOutput()
    {
        $fileName   = 'writesOutputToCsvAndReturns0.csv';
        $fileSystem = vfsStream::setup();

        $outputter = new CsvOutputter($fileSystem->url() . '/', $fileName);

        $paymentDates = array(
            new PaymentDates(new Month(10), new Year('2010')),
            new PaymentDates(new Month(11), new Year('2010')),
            new PaymentDates(new Month(12), new Year('2010'))
        );

        $actualExitCode = $outputter->execute($paymentDates, new NullOutput());

        $this->assertSame(
            file_get_contents(__DIR__ . '/resources/' . $fileName),
            $fileSystem->getChild($fileName)->getContent()
        );

        $this->assertSame(0, $actualExitCode);
    }

    public function test_execute_writesFileNameToConsole_onSuccessfulOutput()
    {
        $fileName   = 'writesFileNameToConsole.csv';
        $fileSystem = vfsStream::setup();

        $mockedOutput = $this->createMock(OutputInterface::class);
        $mockedOutput->expects($this->once())
            ->method('writeln')
            ->with('Outputted payment dates to "' . $fileSystem->url() . '/' . $fileName . '"');

        $outputter = new CsvOutputter($fileSystem->url() . '/', $fileName);
        $outputter->execute(
            array(), // By passing an empty array, writeln() will only be called a single time so we can accurately test
            $mockedOutput
        );
    }

    public function test_execute_throwsUnableToCreateDirectoryException_ifCreatingOutputDirectoryFails()
    {
        $fileName  = 'throwsUnableToCreateDirectoryException';

        // Create a filesystem we can read, but can't write to, this way we can't create the directory
        $fileSystem = vfsStream::setup('root', 0444);

        $outputter = new CsvOutputter(
            $fileSystem->url() . '/output', // The output directory won't exist yet
            $fileName
        );

        $this->expectException(UnableToCreateDirectoryException::class);
        $outputter->execute(array(), new NullOutput());
    }

    public function test_execute_throwsUnableToWriteFileException_ifWritingToFileFails()
    {
        $fileName  = 'throwsUnableToCreateDirectoryException';

        // Create a filesystem we can read, but can't write to, this way we can't create the file
        $fileSystem = vfsStream::setup('root', 0444);

        $outputter = new CsvOutputter(
            $fileSystem->url() . '/', // The output directory won't exist yet
            $fileName
        );

        $this->expectException(UnableToWriteFileException::class);
        $outputter->execute(array(), new NullOutput());
    }

    public function dataProvider_emptyFileNames(): array
    {
        return array(
            'nullAsFileName'        => array(null),
            'emptyStringAsFileName' => array(null)
        );
    }
}
