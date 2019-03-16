<?php

namespace Test\Brownie\BpmOnline\DataService\Column;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Column\ColumnFilter;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\MethodProphecy;

class ColumnFilterTest extends TestCase
{

    /**
     * @var ColumnFilter
     */
    private $columnFilter;

    protected function setUp()
    {
    }

    protected function tearDown()
    {
        $this->columnFilter = null;
    }

    public function testToArrayCompareFilter()
    {
        $this->columnFilter = new ColumnFilter(
            ColumnFilter::FILTER_COMPARE,
            ColumnFilter::COMPARISON_EQUAL,
            $this->createColumnExpression('key1', 'value1'),
            $this->createColumnExpression('key2', 'value2')
        );

        $this->assertEquals([
            'FilterType' => 1,
            'ComparisonType' => 3,
            'LeftExpression' => [
                'key1' => 'value1',
            ],
            'RightExpression' => [
                'key2' => 'value2',
            ],
        ], $this->columnFilter->toArray());
    }

    public function testToArrayBetWeen()
    {
        $this->columnFilter = new ColumnFilter(
            ColumnFilter::FILTER_BETWEEN,
            ColumnFilter::COMPARISON_BETWEEN,
            $this->createColumnExpression('key1', 'value1'),
            $this->createColumnExpression('key2', 'value2'),
            $this->createColumnExpression('key3', 'value3')
        );

        $this->assertEquals([
            'FilterType' => 3,
            'ComparisonType' => 0,
            'LeftExpression' => [
                'key1' => 'value1',
            ],
            'RightLessExpression' => [
                'key2' => 'value2',
            ],
            'RightGreaterExpression' => [
                'key3' => 'value3',
            ],
        ], $this->columnFilter->toArray());
    }

    public function testValidate()
    {
        $this->columnFilter = new ColumnFilter(
            ColumnFilter::FILTER_BETWEEN,
            ColumnFilter::COMPARISON_BETWEEN,
            $this->createColumnExpression('key1', 'value1'),
            $this->createColumnExpression('key2', 'value2'),
            $this->createColumnExpression('key3', 'value3')
        );
        $this->assertNull($this->columnFilter->validate());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidatExceptionComapreColumnFilter()
    {
        $this->columnFilter = new ColumnFilter(
            ColumnFilter::FILTER_COMPARE,
            ColumnFilter::COMPARISON_EQUAL
        );
        $this->columnFilter->validate();
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidatExceptionBetweenColumnFilter()
    {
        $this->columnFilter = new ColumnFilter(
            ColumnFilter::FILTER_BETWEEN,
            ColumnFilter::COMPARISON_BETWEEN
        );
        $this->columnFilter->validate();
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidatExceptionFilter()
    {
        $this->columnFilter = new ColumnFilter(
            9999,
            ColumnFilter::COMPARISON_BETWEEN
        );
        $this->columnFilter->validate();
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidatExceptionComparison()
    {
        $this->columnFilter = new ColumnFilter(
            ColumnFilter::FILTER_BETWEEN,
            9999
        );
        $this->columnFilter->validate();
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
