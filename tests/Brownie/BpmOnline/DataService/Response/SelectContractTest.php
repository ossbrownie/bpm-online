<?php

namespace Test\Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Response\SelectContract;
use PHPUnit\Framework\TestCase;

class SelectContractTest extends TestCase
{

    /**
     * @var SelectContract
     */
    private $responseSelectContract;

    protected function setUp()
    {
        $this->responseSelectContract = new SelectContract('{"rowConfig":{"Id":{"dataValueType":0},"Contact Name":{"dataValueType":1},"Contact Email":{"dataValueType":1},"Photo":{"dataValueType":16,"isLookup":true,"referenceSchemaName":"SysImage"}},"rows":[{"Contact Name":"Developer Tester Testerovich","Contact Email":"tester@developer.dev","Id":"97401040-6390-4b9a-964a-3844ff10cd6a","Photo":""}],"notFoundColumns":[],"rowsAffected":1,"nextPrcElReady":false,"success":false}');
    }

    protected function tearDown()
    {
        $this->responseSelectContract = null;
    }

    public function testGetters()
    {
        $this->assertEquals(1, $this->responseSelectContract->getRowsAffected());
        $this->assertFalse($this->responseSelectContract->getNextPrcElReady());
        $this->assertFalse($this->responseSelectContract->getSuccess());
        $this->assertEquals([
            'Id' => ['dataValueType' => 0],
            'Contact Name' => ['dataValueType' => 1],
            'Contact Email' => ['dataValueType' => 1],
            'Photo' => [
                'dataValueType' => 16,
                'isLookup' => true,
                'referenceSchemaName' => 'SysImage',
            ]
        ], $this->responseSelectContract->getRowConfig());
        $this->assertEquals([
            [
                'Contact Name' => 'Developer Tester Testerovich',
                'Contact Email' => 'tester@developer.dev',
                'Id' => '97401040-6390-4b9a-964a-3844ff10cd6a',
                'Photo' => '',
            ],
        ], $this->responseSelectContract->getRows());
    }
}
