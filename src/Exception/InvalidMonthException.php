<?php
declare(strict_types=1);

namespace MikkoTest\Exception;

class InvalidMonthException extends \InvalidArgumentException
{
    public static function becauseProvidedMonthIsOutOfBounds()
    {
        return new self('The month has to be a value between 1 and 12');
    }
}