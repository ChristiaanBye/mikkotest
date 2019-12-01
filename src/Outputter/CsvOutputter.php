<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use MikkoTest\Exception\InvalidFileNameException;
use Symfony\Component\Console\Output\OutputInterface;

class CsvOutputter implements OutputterInterface
{
    /**
     * @var string
     */
    private $fileName;

    public function __construct(?string $fileName)
    {
        $this->fileNameMustBeProvided($fileName);

        $this->fileName = $fileName;
    }

    public function execute(array $paymentDates, OutputInterface $output): void
    {
        // TODO: Implement execute() method.
    }

    private function fileNameMustBeProvided(?string $fileName)
    {
        if (empty($fileName)) {
            throw InvalidFileNameException::becauseMandatoryFileNameWasNotProvided();
        }
    }
}