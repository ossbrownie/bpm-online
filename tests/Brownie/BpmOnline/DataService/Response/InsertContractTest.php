<?php

namespace Test\Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Response\InsertContract;
use PHPUnit\Framework\TestCase;

class InsertContractTest extends TestCase
{

    /**
     * @var InsertContract
     */
    private $responseInsertContract;

    protected function setUp()
    {
        $this->responseInsertContract = new InsertContract('{"id":"97401040-6390-4b9a-964a-3844ff10cd6a","rowsAffected":1,"nextPrcElReady":false,"success":true}');
    }

    protected function tearDown()
    {
        $this->responseInsertContract = null;
    }

    public function testGetters()
    {
        $this->assertEquals(1, $this->responseInsertContract->getRowsAffected());
        $this->assertFalse($this->responseInsertContract->getNextPrcElReady());
        $this->assertTrue($this->responseInsertContract->getSuccess());
        $this->assertEquals('97401040-6390-4b9a-964a-3844ff10cd6a', $this->responseInsertContract->getId());
    }
}
