<?php

namespace Test\Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Column\ColumnFilter;
use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Contract\UpdateContract;
use Prophecy\Prophecy\MethodProphecy;
use Brownie\BpmOnline\DataService\Response\UpdateContract as ResponseUpdateContract;

class UpdateContractTest extends TestCase
{

    /**
     * @var UpdateContract
     */
    private $updateContract;

    protected function setUp()
    {
        $this->updateContract = new UpdateContract('rootSchemaName');
    }

    protected function tearDown()
    {
        $this->updateContract = null;
    }

    public function testSetGetRootSchemaName()
    {
        $this->assertEquals('rootSchemaName', $this->updateContract->getRootSchemaName());
        $this->updateContract->setRootSchemaName('TestRootSchemaName');
        $this->assertEquals('TestRootSchemaName', $this->updateContract->getRootSchemaName());
    }

    public function testSetGetOperationType()
    {
        $this->assertEquals(2, $this->updateContract->getOperationType());
        $this->updateContract->setOperationType(200);
        $this->assertEquals(200, $this->updateContract->getOperationType());
    }

    public function testSetGetContractType()
    {
        $this->assertEquals('UpdateQuery', $this->updateContract->getContractType());
        $this->updateContract->setContractType('TestUpdateQuery');
        $this->assertEquals('TestUpdateQuery', $this->updateContract->getContractType());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this->updateContract->setOperationType(1);
        $this->assertNull($this->updateContract->validate());
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

        $updateContract = $this->updateContract->addFilter($columnFilter->reveal());

        $this->assertInstanceOf(UpdateContract::class, $updateContract);
        $this->assertNull($this->updateContract->validate());
    }

    public function testAddColumn()
    {
        $columnExpression = $this->prophesize(ColumnExpression::class);
        $columnExpressionMethodToArray = new MethodProphecy(
            $columnExpression,
            'toArray',
            []
        );
        $columnExpression
            ->addMethodProphecy(
                $columnExpressionMethodToArray->willReturn(['test' => 'Ok'])
            );

        $updateContract = $this->updateContract->addColumn('TestColumn', $columnExpression->reveal());

        $this->assertInstanceOf(UpdateContract::class, $updateContract);
        $this->assertEquals([
            'test' => 'Ok',
        ], $this->updateContract->toArray()['ColumnValues']['Items']['TestColumn']);
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

        $updateContract = $this->updateContract->addFilter($columnFilter->reveal());

        $this->assertInstanceOf(UpdateContract::class, $updateContract);
        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 2,
            'IsForceUpdate' => false,
            'ColumnValues' => [
                'Items' => [],
            ],
            'Filters' => [
                'test' => 'Ok',
            ],
        ], $this->updateContract->toArray());
    }

    public function testToArray()
    {
        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 2,
            'IsForceUpdate' => false,
            'ColumnValues' => [
                'Items' => [],
            ],
            'Filters' => [],
        ], $this->updateContract->toArray());
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf(
            ResponseUpdateContract::class,
            $this->updateContract->getResponse('{}')
        );
    }
}
