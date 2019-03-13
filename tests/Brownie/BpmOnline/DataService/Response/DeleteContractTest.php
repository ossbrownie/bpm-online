<?php

namespace Test\Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Response\DeleteContract;
use PHPUnit\Framework\TestCase;

class DeleteContractTest extends TestCase
{

    /**
     * @var DeleteContract
     */
    private $responseDeleteContract;

    protected function setUp()
    {
        $this->responseDeleteContract = new DeleteContract('{"rowsAffected":1,"nextPrcElReady":false,"success":false}');
    }

    protected function tearDown()
    {
        $this->responseDeleteContract = null;
    }

    public function testGetters()
    {
        $this->assertEquals(1, $this->responseDeleteContract->getRowsAffected());
        $this->assertFalse($this->responseDeleteContract->getNextPrcElReady());
        $this->assertFalse($this->responseDeleteContract->getSuccess());
    }
}
