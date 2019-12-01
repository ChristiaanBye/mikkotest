<?php
declare(strict_types=1);

namespace MikkoTest\Exception;

class InvalidYearException extends \InvalidArgumentException
{
    public static function becauseProvidedYearIsNotValid(\Exception $previousException)
    {
        return new self('The year has to be a valid numeric value', 0, $previousException);
    }
}