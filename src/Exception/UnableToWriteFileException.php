<?php
declare(strict_types=1);

namespace MikkoTest\Exception;

use Throwable;

class UnableToWriteFileException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The .csv file to write to was unable to be created. Is the working directory write protected?');
    }
}