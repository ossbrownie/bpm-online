<?php

namespace Test\Brownie\BpmOnline\DataService\Column;

use Brownie\BpmOnline\DataService\Column\Expression;
use PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{

    /**
     * @var Expression
     */
    private $expression;

    protected function setUp()
    {
        $this->expression = new Expression([
            'value' => 'testValue'
        ]);
    }

    protected function tearDown()
    {
        $this->expression = null;
    }

    public function testGetKeyName()
    {
        $this->assertNull($this->expression->getKeyName());
    }

    public function testSetGetValue()
    {
        $this->assertEquals('testValue', $this->expression->getValue());
        $this->expression->setValue('valueTest');
        $this->assertEquals('valueTest', $this->expression->getValue());
    }
}
