<?php
declare(strict_types=1);

namespace MikkoTest\Exception;

class InvalidFileNameException extends \InvalidArgumentException
{
    public static function becauseMandatoryFileNameWasNotProvided()
    {
        return new self('Providing a file name is a mandatory');
    }
}