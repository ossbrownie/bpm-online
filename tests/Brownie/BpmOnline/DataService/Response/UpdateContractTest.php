<?php

namespace Test\Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Response\UpdateContract;
use PHPUnit\Framework\TestCase;

class UpdateContractTest extends TestCase
{

    /**
     * @var UpdateContract
     */
    private $responseUpdateContract;

    protected function setUp()
    {
        $this->responseUpdateContract = new UpdateContract('{"rowsAffected":1,"nextPrcElReady":false,"success":true}');
    }

    protected function tearDown()
    {
        $this->responseUpdateContract = null;
    }

    public function testGetters()
    {
        $this->assertEquals(1, $this->responseUpdateContract->getRowsAffected());
        $this->assertFalse($this->responseUpdateContract->getNextPrcElReady());
        $this->assertTrue($this->responseUpdateContract->getSuccess());
    }
}
