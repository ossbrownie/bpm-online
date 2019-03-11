<?php

namespace Test\Brownie\BpmOnline\DataService\Column;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Column\Expression\ColumnPath;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;

class ColumnExpressionTest extends TestCase
{

    /**
     * @var ColumnExpression
     */
    private $columnExpression;

    protected function setUp()
    {
        $this->columnExpression = new ColumnExpression(
            $this->createExpression('TestKey1', 'TestValue1'),
            $this->createExpression('TestKey2', 'TestValue2'),
            $this->createExpression('TestKey3', 'TestValue3')
        );
    }

    protected function tearDown()
    {
        $this->columnExpression = null;
    }

    public function testToArray()
    {
        $this->assertEquals([
            'TestKey1' => 'TestValue1',
            'TestKey2' => 'TestValue2',
            'TestKey3' => 'TestValue3',
        ], $this->columnExpression->toArray());
    }

    private function createExpression($key, $value)
    {
        $expression = $this->prophesize(ColumnPath::class);

        $columnExpressionMethodGetKeyName = new MethodProphecy(
            $expression,
            'getKeyName',
            []
        );
        $expression
            ->addMethodProphecy(
                $columnExpressionMethodGetKeyName->willReturn($key)
            );

        $columnExpressionMethodGetValue = new MethodProphecy(
            $expression,
            'getValue',
            []
        );
        $expression
            ->addMethodProphecy(
                $columnExpressionMethodGetValue->willReturn($value)
            );

        return $expression->reveal();
    }
}
