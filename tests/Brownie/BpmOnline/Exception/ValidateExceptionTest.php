<?php

namespace Test\Brownie\BpmOnline\Exception;

use Brownie\BpmOnline\Exception\ValidateException;
use PHPUnit\Framework\TestCase;

class ValidateExceptionTest extends TestCase
{

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testException()
    {
        throw new ValidateException('Test');
    }
}
