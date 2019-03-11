<?php

namespace Test\Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression\ColumnPath;
use PHPUnit\Framework\TestCase;

class ColumnPathTest extends TestCase
{

    /**
     * @var ColumnPath
     */
    private $columnPath;

    protected function setUp()
    {
        $this->columnPath = new ColumnPath('[Name].id');
    }

    protected function tearDown()
    {
        $this->columnPath = null;
    }

    public function testGetKeyName()
    {
        $this->assertEquals('ColumnPath', $this->columnPath->getKeyName());
    }

    public function testSetGetValue()
    {
        $this->assertEquals('[Name].id', $this->columnPath->getValue());
        $this->columnPath->setValue('test');
        $this->assertEquals('test', $this->columnPath->getValue());
    }

    public function testToArray()
    {
        $this->assertEquals([
            'value' => '[Name].id',
        ], $this->columnPath->toArray());
    }
}
