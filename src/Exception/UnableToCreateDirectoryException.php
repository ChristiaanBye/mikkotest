<?php
declare(strict_types=1);

namespace MikkoTest\Exception;

class UnableToCreateDirectoryException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The output directory was unable to be created. Is the working directory write protected?');
    }
}