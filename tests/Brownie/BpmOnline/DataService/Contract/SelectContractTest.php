<?php

namespace Test\Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Column\ColumnFilter;
use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Contract\SelectContract;
use Prophecy\Prophecy\MethodProphecy;

class SelectContractTest extends TestCase
{

    /**
     * @var SelectContract
     */
    private $selectContract;

    protected function setUp()
    {
        $this->selectContract = new SelectContract('rootSchemaName');
    }

    protected function tearDown()
    {
        $this->selectContract = null;
    }

    public function testSetGetRootSchemaName()
    {
        $this->assertEquals('rootSchemaName', $this->selectContract->getRootSchemaName());
        $this->selectContract->setRootSchemaName('TestRootSchemaName');
        $this->assertEquals('TestRootSchemaName', $this->selectContract->getRootSchemaName());
    }

    public function testSetGetOperationType()
    {
        $this->assertEquals(0, $this->selectContract->getOperationType());
        $this->selectContract->setOperationType(50);
        $this->assertEquals(50, $this->selectContract->getOperationType());
    }

    public function testSetGetContractType()
    {
        $this->assertEquals('SelectQuery', $this->selectContract->getContractType());
        $this->selectContract->setContractType('TestSelectQuery');
        $this->assertEquals('TestSelectQuery', $this->selectContract->getContractType());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this->selectContract->setOperationType(1);
        $this->assertNull($this->selectContract->validate());
    }

    public function testValidate()
    {
        $this->assertNull($this->selectContract->validate());
    }

    public function testSetGetAllColumns()
    {
        $this->assertFalse($this->selectContract->toArray()['AllColumns']);
        $this->selectContract->setIsAllColumns(true);
        $this->assertTrue($this->selectContract->toArray()['AllColumns']);
    }

    public function testSetGetIsPageable()
    {
        $this->assertFalse($this->selectContract->toArray()['IsPageable']);
        $this->selectContract->setIsPageable(true);
        $this->assertTrue($this->selectContract->toArray()['IsPageable']);
    }

    public function testSetGetIsDistinct()
    {
        $this->assertFalse($this->selectContract->toArray()['IsDistinct']);
        $this->selectContract->setIsDistinct(true);
        $this->assertTrue($this->selectContract->toArray()['IsDistinct']);
    }

    public function testSetGetRowCount()
    {
        $this->assertEquals(-1, $this->selectContract->toArray()['RowCount']);
        $this->selectContract->setRowCount(100);
        $this->assertEquals(100, $this->selectContract->toArray()['RowCount']);
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

        $selectContract = $this->selectContract->addColumn(
            'TestColumn',
            'asc', 0,
            'Test Name Column',
            $columnExpression->reveal()
        );

        $this->assertInstanceOf(SelectContract::class, $selectContract);

        $this->assertEquals([
            'OrderDirection' => 'asc',
            'OrderPosition' => 0,
            'Caption' => 'Test Name Column',
            'Expression' => ['test' => 'Ok'],
        ], $this->selectContract->toArray()['Columns']['Items']['TestColumn']);
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

        $selectContract = $this->selectContract->addFilter($columnFilter->reveal());

        $this->assertInstanceOf(SelectContract::class, $selectContract);

        $this->assertEquals([
            'test' => 'Ok'
        ], $this->selectContract->toArray()['Filters']);
    }

    public function testToArray()
    {
        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 0,
            'Columns' =>
                array (
                    'Items' =>
                        array (
                        ),
                ),
            'AllColumns' => false,
            'IsPageable' => false,
            'IsDistinct' => false,
            'RowCount' => -1,
        ], $this->selectContract->toArray());
    }
}
