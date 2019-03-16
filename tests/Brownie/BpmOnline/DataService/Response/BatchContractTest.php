<?php

namespace Test\Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Response\BatchContract;
use Brownie\BpmOnline\DataService\Contract\InsertContract;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Test\Brownie\BpmOnline\DataService\ContractInterface;

class BatchContractTest extends TestCase
{

    /**
     * @var BatchContract
     */
    private $batchContractResponse;

    protected function setUp()
    {
        $insertContract1 = $this->prophesize(InsertContract::class);
        $insertContract1MethodgetResponse = new MethodProphecy(
            $insertContract1,
            'getResponse',
            ['{"id":"fa056b6e-2991-43ad-be24-05155cd090a4","rowsAffected":1,"nextPrcElReady":false,"success":true}']
        );
        $insertContract1
            ->addMethodProphecy(
                $insertContract1MethodgetResponse->willReturn('InsertQuery1')
            );

        $insertContract2 = $this->prophesize(InsertContract::class);
        $insertContract2MethodgetResponse = new MethodProphecy(
            $insertContract2,
            'getResponse',
            ['{"id":"fe613228-2ed1-40ee-8e24-ad31a4904992","rowsAffected":1,"nextPrcElReady":false,"success":true}']
        );
        $insertContract2
            ->addMethodProphecy(
                $insertContract2MethodgetResponse->willReturn('InsertQuery2')
            );

        $contracts = [$insertContract1->reveal(), $insertContract2->reveal()];

        $this->batchContractResponse = new BatchContract(
            '{"queryResults":[{"id":"fa056b6e-2991-43ad-be24-05155cd090a4","rowsAffected":1,"nextPrcElReady":false,"success":true},{"id":"fe613228-2ed1-40ee-8e24-ad31a4904992","rowsAffected":1,"nextPrcElReady":false,"success":true}]}',
            $contracts
        );
    }

    protected function tearDown()
    {
        $this->batchContractResponse = null;
    }

    public function testGetContractsResponse()
    {
        $this->assertEquals([
            'InsertQuery1',
            'InsertQuery2',
        ], $this->batchContractResponse->getContractsResponse());
    }
}
