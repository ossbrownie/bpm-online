<?php

namespace Test\Brownie\BpmOnline\Exception;

use Brownie\BpmOnline\Exception\AuthenticationException;
use PHPUnit\Framework\TestCase;

class AuthenticationExceptionTest extends TestCase
{

    /**
     * @expectedException \Brownie\BpmOnline\Exception\AuthenticationException
     */
    public function testException()
    {
        throw new AuthenticationException('Test');
    }
}
