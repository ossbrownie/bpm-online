<?php

namespace Test\Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Column\ColumnFilter;
use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Contract\DeleteContract;
use Prophecy\Prophecy\MethodProphecy;

class DeleteContractTest extends TestCase
{

    /**
     * @var DeleteContract
     */
    private $deleteContract;

    protected function setUp()
    {
        $this->deleteContract = new DeleteContract('rootSchemaName');
    }

    protected function tearDown()
    {
        $this->deleteContract = null;
    }

    public function testSetGetRootSchemaName()
    {
        $this->assertEquals('rootSchemaName', $this->deleteContract->getRootSchemaName());
        $this->deleteContract->setRootSchemaName('TestRootSchemaName');
        $this->assertEquals('TestRootSchemaName', $this->deleteContract->getRootSchemaName());
    }

    public function testSetGetOperationType()
    {
        $this->assertEquals(3, $this->deleteContract->getOperationType());
        $this->deleteContract->setOperationType(300);
        $this->assertEquals(300, $this->deleteContract->getOperationType());
    }

    public function testSetGetContractType()
    {
        $this->assertEquals('DeleteQuery', $this->deleteContract->getContractType());
        $this->deleteContract->setContractType('TestDeleteQuery');
        $this->assertEquals('TestDeleteQuery', $this->deleteContract->getContractType());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this->deleteContract->setOperationType(1);
        $this->assertNull($this->deleteContract->validate());
    }

    public function testValidate()
    {
        $columnFilter = $this->prophesize(ColumnFilter::class);
        $columnFilterMethodToArray = new MethodProphecy(
            $columnFilter,
            'toArray',
            []
        );
        $columnFilter
            ->addMethodProphecy(
                $columnFilterMethodToArray->willReturn(['test' => 'Ok'])
            );

        $columnFilterMethodValidate = new MethodProphecy(
            $columnFilter,
            'validate',
            []
        );
        $columnFilter
            ->addMethodProphecy(
                $columnFilterMethodValidate->willReturn(null)
            );

        $deleteContract = $this->deleteContract->addFilter($columnFilter->reveal());

        $this->assertInstanceOf(DeleteContract::class, $deleteContract);
        $this->assertNull($this->deleteContract->validate());
    }

    public function testAddFilter()
    {
        $columnFilter = $this->prophesize(ColumnFilter::class);
        $columnFilterMethodToArray = new MethodProphecy(
            $columnFilter,
            'toArray',
            []
        );
        $columnFilter
            ->addMethodProphecy(
                $columnFilterMethodToArray->willReturn(['test' => 'Ok'])
            );

        $deleteContract = $this->deleteContract->addFilter($columnFilter->reveal());

        $this->assertInstanceOf(DeleteContract::class, $deleteContract);
        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 3,
            'Filters' => [
                'test' => 'Ok',
            ],
        ], $this->deleteContract->toArray());
    }

    public function testToArray()
    {
        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 3,
            'Filters' => [],
        ], $this->deleteContract->toArray());
    }
}
