<?php

namespace Test\Brownie\BpmOnline\Util;

use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\Util\DateTime as UtilDateTime;

class DateTime extends TestCase
{

    /**
     * @var UtilDateTime
     */
    private $dateTime;

    protected function setUp()
    {
    }

    protected function tearDown()
    {
        $this->dateTime = null;
    }

    public function testDateTimeNull()
    {
        $this->dateTime = new UtilDateTime();
        $this->assertNotEmpty($this->dateTime->__toString());
    }


    public function testDateTimeInt()
    {
        $dateTime = '2019-01-15T10:30:20+00:00';
        $timeStamp = strtotime($dateTime);
        $this->dateTime = new UtilDateTime($timeStamp);
        $this->assertEquals('"' . $dateTime . '"', $this->dateTime->__toString());
    }

    public function testDateTimeString()
    {
        $dateTime = '2019-01-15T10:30:20+00:00';
        $this->dateTime = new UtilDateTime($dateTime);
        $this->assertEquals('"' . $dateTime . '"', $this->dateTime->__toString());
    }
}
