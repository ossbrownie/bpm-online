<?php

namespace Test\Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression\Parameter;
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{

    /**
     * @var Parameter
     */
    private $parameter;

    protected function setUp()
    {
        $this->parameter = new Parameter('Test', Parameter::TEXT);
    }

    protected function tearDown()
    {
        $this->parameter = null;
    }

    public function testGetKeyName()
    {
        $this->assertEquals('Parameter', $this->parameter->getKeyName());
    }

    public function testSetGetValue()
    {
        $parameter = $this->parameter->setValue('TestString');
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals([
            'DataValueType' => 1,
            'Value' => 'TestString'
        ], $this->parameter->getValue());
    }

    public function testArrayValue()
    {
        $parameter = $this->parameter->setArrayValue([
            'test' => 'ok'
        ]);
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals([
            'DataValueType' => 1,
            'Value' => 'Test',
            'ArrayValue' => [
                'test' => 'ok',
            ],
        ], $this->parameter->getValue());
    }

    public function testShouldSkipConvertion()
    {
        $parameter = $this->parameter->setShouldSkipConvertion(true);
        $this->assertInstanceOf(Parameter::class, $parameter);
        $this->assertEquals([
            'DataValueType' => 1,
            'Value' => 'Test',
            'ShouldSkipConvertion' => true,
        ], $this->parameter->getValue());
    }
}
