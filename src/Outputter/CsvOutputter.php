<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use MikkoTest\Exception\InvalidFileNameException;
use MikkoTest\Exception\UnableToCreateDirectoryException;
use MikkoTest\Exception\UnableToWriteFileException;
use Symfony\Component\Console\Output\OutputInterface;

class CsvOutputter extends Outputter implements OutputterInterface
{
    public const DEFAULT_OUTPUT_DIRECTORY = 'output/';

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $outputDirectory;

    public function __construct(string $outputDirectory, ?string $fileName)
    {
        $this->outputDirectory = $outputDirectory;

        $this->fileNameMustBeProvided($fileName);
        $this->fileName = $fileName;

    }

    /**
     * @param array           $paymentDates
     * @param OutputInterface $output
     *
     * @return int
     * @throws UnableToCreateDirectoryException
     * @throws UnableToWriteFileException
     */
    public function execute(array $paymentDates, OutputInterface $output): int
    {
        if (file_exists($this->outputDirectory) === false) {
            $directoryCreated = mkdir($this->outputDirectory);

            if ($directoryCreated === false) {
                throw new UnableToCreateDirectoryException();
            }
        }

        $handle = @fopen($this->outputDirectory . $this->fileName, 'w');

        if ($handle === false) {
            // When the handle is false, this indicates the file could not be opened for writing
            throw new UnableToWriteFileException();
        }

        foreach ($paymentDates as $paymentDate) {
            fputcsv(
                $handle,
                $this->generateOutputRow($paymentDate),
                ','
            );
        }

        fclose($handle);

        $output->writeln('Outputted payment dates to "' . $this->outputDirectory . $this->fileName . '"');

        return 0;
    }

    private function fileNameMustBeProvided(?string $fileName)
    {
        if (empty($fileName)) {
            throw InvalidFileNameException::becauseMandatoryFileNameWasNotProvided();
        }
    }
}