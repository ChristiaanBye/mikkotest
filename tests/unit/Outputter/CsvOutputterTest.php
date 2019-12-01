<?php
declare(strict_types=1);

namespace MikkoTest\Outputter;

use MikkoTest\Exception\InvalidFileNameException;
use PHPUnit\Framework\TestCase;

class CsvOutputterTest extends TestCase
{
    /**
     * @dataProvider dataProvider_emptyFileNames
     */
    public function test_constructor_throwsInvalidFileNameException_ifFileNameIsNotProvided($emptyFileName)
    {
        $this->expectException(InvalidFileNameException::class);
        new CsvOutputter($emptyFileName);
    }

    public function dataProvider_emptyFileNames(): array
    {
        return array(
            'nullAsFileName'        => array(null),
            'emptyStringAsFileName' => array(null)
        );
    }
}
