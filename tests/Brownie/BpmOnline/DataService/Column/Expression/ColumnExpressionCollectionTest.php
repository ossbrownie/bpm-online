<?php

namespace Test\Brownie\BpmOnline\DataService\Column;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Column\ColumnExpressionCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;

class ColumnExpressionCollectionTest extends TestCase
{

    /**
     * @var ColumnExpressionCollection
     */
    private $columnExpressionCollection;

    protected function setUp()
    {
        $this->columnExpressionCollection = new ColumnExpressionCollection([
            $this->createColumnExpression('key1', 'value1'),
            $this->createColumnExpression('key2', 'value2'),
            $this->createColumnExpression('key3', 'value3')
        ]);
    }

    protected function tearDown()
    {
        $this->columnExpressionCollection = null;
    }

    public function testToArray()
    {
        $this->assertEquals([
            [
                'key1' => 'value1',
            ],
            [
                'key2' => 'value2',
            ],
            [
                'key3' => 'value3',
            ]
        ], $this->columnExpressionCollection->toArray());
    }

    private function createColumnExpression($key, $value)
    {
        $columnExpression = $this->prophesize(ColumnExpression::class);
        $columnExpressionMethodToArray = new MethodProphecy(
            $columnExpression,
            'toArray',
            []
        );
        $columnExpression
            ->addMethodProphecy(
                $columnExpressionMethodToArray->willReturn([
                    $key => $value
                ])
            );
        return $columnExpression->reveal();
    }
}
