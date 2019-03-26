<?php

namespace Test\Brownie\BpmOnline\DataService\Contract;

use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Contract\BatchContract;
use Brownie\BpmOnline\DataService\Contract\InsertContract;
use Prophecy\Prophecy\MethodProphecy;
use Test\Brownie\BpmOnline\DataService\ContractInterface;
use Brownie\BpmOnline\DataService\Response\BatchContract as ResponseBranchContract;

class BatchContractTest extends TestCase
{

    /**
     * @var BatchContract
     */
    private $batchContract;

    protected function setUp()
    {
        $this->batchContract = new BatchContract();
    }

    protected function tearDown()
    {
        $this->batchContract = null;
    }

    public function testAddContract()
    {
        $insertContract = $this->prophesize(InsertContract::class);
        $this->assertInstanceOf(
            BatchContract::class,
            $this->batchContract->addContract($insertContract->reveal())
        );
    }

    public function testToArray()
    {
        $insertContract = $this->prophesize(InsertContract::class);
        $insertContract->willImplement(ContractInterface::class);
        $insertContractMethodGetContractType = new MethodProphecy(
            $insertContract,
            'getContractType',
            []
        );
        $insertContract
            ->addMethodProphecy(
                $insertContractMethodGetContractType->willReturn('InsertQuery')
            );
        $insertContractMethodToArray = new MethodProphecy(
            $insertContract,
            'toArray',
            []
        );
        $insertContract
            ->addMethodProphecy(
                $insertContractMethodToArray->willReturn(['test' => 'ok'])
            );

        $this->assertInstanceOf(
            BatchContract::class,
            $this->batchContract->addContract($insertContract->reveal())
        );
        $this->assertEquals([
            'items' => [
                [
                    '__type' => 'Terrasoft.Nui.ServiceModel.DataContract.InsertQuery',
                    'test' => 'ok'
                ]
            ]
        ], $this->batchContract->toArray());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidateValidateException()
    {
        $this->batchContract->validate();
    }

    public function testValidate()
    {
        $insertContract = $this->prophesize(InsertContract::class);

        $this->assertInstanceOf(
            BatchContract::class,
            $this->batchContract->addContract($insertContract->reveal())
        );

        $this->assertNull($this->batchContract->validate());
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf(
            ResponseBranchContract::class,
            $this->batchContract->getResponse('{}')
        );
    }

    public function testCount()
    {
        $insertContract1 = $this->prophesize(InsertContract::class);
        $this->assertInstanceOf(
            BatchContract::class,
            $this->batchContract->addContract($insertContract1->reveal())
        );
        $insertContract2 = $this->prophesize(InsertContract::class);
        $this->assertInstanceOf(
            BatchContract::class,
            $this->batchContract->addContract($insertContract2->reveal())
        );
        $this->assertEquals(2, $this->batchContract->count());
        $this->assertNull($this->batchContract->validate());
    }
}
