<?php
declare(strict_types=1);

namespace MikkoTest\ValueObject;

use MikkoTest\Exception\InvalidMonthException;

class Month
{
    /**
     * @var int
     */
    private $month;

    public function __construct(int $month)
    {
        $this->monthMustBeAValidMonth($month);

        $this->month = $month;
    }

    public function getFullTextMonth(): string
    {
        switch ($this->month) {
            case 1:
                return 'January';
            case 2:
                return 'February';
            case 3:
                return 'March';
            case 4:
                return 'April';
            case 5:
                return 'May';
            case 6:
                return 'June';
            case 7:
                return 'July';
            case 8:
                return 'August';
            case 9:
                return 'September';
            case 10:
                return 'October';
            case 11:
                return 'November';
            case 12:
                return 'December';
        }

        // We should never reach this line, but just to be absolutely sure...
        throw InvalidMonthException::becauseProvidedMonthIsOutOfBounds();
    }

    public function getNumericMonth(): int
    {
        return $this->month;
    }

    private function monthMustBeAValidMonth(int $month): void
    {
        if ($month < 1 || $month > 12) {
            throw InvalidMonthException::becauseProvidedMonthIsOutOfBounds();
        }
    }
}