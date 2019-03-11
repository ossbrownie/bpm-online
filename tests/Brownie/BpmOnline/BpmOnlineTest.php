<?php

namespace Test\Brownie\BpmOnline;

use Brownie\BpmOnline\BpmOnline;
use Brownie\BpmOnline\Config;
use Brownie\HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class BpmOnlineTest extends TestCase
{

    /**
     * @var BpmOnline
     */
    private $bpmOnline;

    protected function setUp()
    {
        $httpClient = $this->prophesize(HttpClient::class);

        $config = $this->prophesize(Config::class);



        $this->bpmOnline = new BpmOnline(
            $httpClient->reveal(),
            $config->reveal()
        );
    }

    protected function tearDown()
    {
        $this->bpmOnline = null;
    }
}
