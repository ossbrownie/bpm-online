<?php

namespace Test\Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression\ExpressionType;
use PHPUnit\Framework\TestCase;

class ExpressionTypeTest extends TestCase
{

    /**
     * @var ExpressionType
     */
    private $expressionType;

    protected function setUp()
    {
        $this->expressionType = new ExpressionType(ExpressionType::ARITHMETIC_OPERATION);
    }

    protected function tearDown()
    {
        $this->expressionType = null;
    }

    public function testGetKeyName()
    {
        $this->assertEquals('ExpressionType', $this->expressionType->getKeyName());
    }

    public function testSetGetValue()
    {
        $this->assertEquals(ExpressionType::ARITHMETIC_OPERATION, $this->expressionType->getValue());
        $this->expressionType->setValue(ExpressionType::PARAMETER);
        $this->assertEquals(ExpressionType::PARAMETER, $this->expressionType->getValue());
    }

    public function testToArray()
    {
        $this->assertEquals([
            'value' => ExpressionType::ARITHMETIC_OPERATION,
        ], $this->expressionType->toArray());
    }
}
