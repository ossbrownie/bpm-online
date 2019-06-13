<?php

namespace Test\Brownie\BpmOnline\DataService;

use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Response;

class ResponseTest extends TestCase
{

    /**
     * @var Response
     */
    private $response;

    protected function setUp()
    {
        $this->response = new Response('{"rowsAffected":"5","nextPrcElReady":false,"success":true,"responseStatus":{"Message":"Test message"}}');
    }

    protected function tearDown()
    {
        $this->response = null;
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testParseResponseInvalidValidateException()
    {
        $this->response = new Response('fail parse');
        $this->response->getRowsAffected();
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testParseResponseUndefinedValidateException()
    {
        $this->response = new Response('{}');
        $this->response->getNextPrcElReady();
    }

    public function testGetters()
    {
        $this->assertEquals(5, $this->response->getRowsAffected());
        $this->assertFalse($this->response->getNextPrcElReady());
        $this->assertTrue($this->response->getSuccess());
        $this->assertEquals('Test message', $this->response->getErrorMessage());
    }

    public function testGettersResponseStrToUpper()
    {
        $this->response = new Response('{"rowsAffected":"5","nextPrcElReady":false,"success":true,"ResponseStatus":{"Message":"Test message"}}');
        $this->assertEquals(5, $this->response->getRowsAffected());
        $this->assertFalse($this->response->getNextPrcElReady());
        $this->assertTrue($this->response->getSuccess());
        $this->assertEquals('Test message', $this->response->getErrorMessage());
    }
}
