<?php

namespace Test\Brownie\BpmOnline\Exception;

use Brownie\BpmOnline\Exception\HttpCodeException;
use PHPUnit\Framework\TestCase;

class HttpCodeExceptionTest extends TestCase
{

    /**
     * @expectedException \Brownie\BpmOnline\Exception\HttpCodeException
     */
    public function testException()
    {
        throw new HttpCodeException('Test');
    }
}
