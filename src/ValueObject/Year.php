<?php
declare(strict_types=1);

namespace MikkoTest\ValueObject;

use Carbon\Carbon;
use MikkoTest\Exception\InvalidYearException;

class Year
{
    /** @var int */
    private $yearNumber;

    /**
     * @param string|null $year When null is provided, the current year is assumed. Otherwise an object representing
     *                          the provided year will be instantiated
     */
    public function __construct(
        ?string $year // string as the value provided from the argument will be a string
    ) {
        if ($year === null) {
            $year = Carbon::now()->format('Y');
        }

        $this->yearMustBeAValidYear($year);

        $this->yearNumber = (int)$year;
    }

    public function getYearNumber(): int
    {
        return $this->yearNumber;
    }

    private function yearMustBeAValidYear(string $year)
    {
        // If we can create a DateTime object with the provided year, it must be valid
        try {
            new \DateTime($year . '-01-01');
        } catch (\Exception $exception) {
            // If it's not valid, a generic exception will be thrown to which a more specific exception will be rethrown
            throw InvalidYearException::becauseProvidedYearIsNotValid($exception);
        }
    }
}