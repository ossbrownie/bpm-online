<?php

namespace Test\Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Contract\InsertContract;
use Prophecy\Prophecy\MethodProphecy;
use Brownie\BpmOnline\DataService\Response\InsertContract as ResponseInsertContract;

class InsertContractTest extends TestCase
{

    /**
     * @var InsertContract
     */
    private $insertContract;

    protected function setUp()
    {
        $this->insertContract = new InsertContract('rootSchemaName');
    }

    protected function tearDown()
    {
        $this->insertContract = null;
    }

    public function testSetGetRootSchemaName()
    {
        $this->assertEquals('rootSchemaName', $this->insertContract->getRootSchemaName());
        $this->insertContract->setRootSchemaName('TestRootSchemaName');
        $this->assertEquals('TestRootSchemaName', $this->insertContract->getRootSchemaName());
    }

    public function testSetGetOperationType()
    {
        $this->assertEquals(1, $this->insertContract->getOperationType());
        $this->insertContract->setOperationType(100);
        $this->assertEquals(100, $this->insertContract->getOperationType());
    }

    public function testSetGetContractType()
    {
        $this->assertEquals('InsertQuery', $this->insertContract->getContractType());
        $this->insertContract->setContractType('TestInsertQuery');
        $this->assertEquals('TestInsertQuery', $this->insertContract->getContractType());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this->insertContract->validate();
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
                $columnExpressionMethodToArray->willReturn([])
            );

        $insertContract = $this->insertContract->addColumn('TestColumn', $columnExpression->reveal());

        $this->assertInstanceOf(InsertContract::class, $insertContract);

        $this->insertContract->validate();
    }

    public function testToArray()
    {
        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 1,
            'ColumnValues' => [
                'Items' => []
            ]
        ], $this->insertContract->toArray());

        $columnExpression = $this->prophesize(ColumnExpression::class);
        $columnExpressionMethodToArray = new MethodProphecy(
            $columnExpression,
            'toArray',
            array()
        );
        $columnExpression
            ->addMethodProphecy(
                $columnExpressionMethodToArray->willReturn([
                    'test' => 'Ok'
                ])
            );

        $this->insertContract->addColumn('TestColumn', $columnExpression->reveal());

        $this->assertEquals([
            'RootSchemaName' => 'rootSchemaName',
            'OperationType' => 1,
            'ColumnValues' => [
                'Items' => [
                    'TestColumn' => ['test' => 'Ok']
                ]
            ]
        ], $this->insertContract->toArray());
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf(
            ResponseInsertContract::class,
            $this->insertContract->getResponse('{}')
        );
    }
}
