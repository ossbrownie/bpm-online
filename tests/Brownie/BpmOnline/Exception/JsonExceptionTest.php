<?php

namespace Test\Brownie\BpmOnline\Exception;

use Brownie\BpmOnline\Exception\JsonException;
use PHPUnit\Framework\TestCase;

class JsonExceptionTest extends TestCase
{

    /**
     * @expectedException \Brownie\BpmOnline\Exception\JsonException
     */
    public function testException()
    {
        throw new JsonException('Test');
    }
}
