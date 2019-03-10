<?php

namespace Test\Brownie\BpmOnline;

use Brownie\BpmOnline\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    /**
     * @var Config
     */
    private $config;

    protected function setUp()
    {
        $this->config = new Config([
            'apiUrlScheme' => 'xxews',
            'apiDomain' => 'test.com',
            'apiConnectTimeOut' => 120,
            'userDomain' => 'devDomain',
            'userName' => 'devLogin',
            'userPassword' => 'devPassword',
        ]);
    }

    protected function tearDown()
    {
        $this->config = null;
    }

    public function testInitConfigParams()
    {
        $this->assertEquals('xxews', $this->config->getApiUrlScheme());
        $this->assertEquals('test.com', $this->config->getApiDomain());
        $this->assertEquals(120, $this->config->getApiConnectTimeOut());
        $this->assertEquals('devDomain', $this->config->getUserDomain());
        $this->assertEquals('devLogin', $this->config->getUserName());
        $this->assertEquals('devPassword', $this->config->getUserPassword());
    }

    public function testSetGetConfigParams()
    {
        $this
            ->config
            ->setApiUrlScheme('https')
            ->setApiDomain('bpmonline.com')
            ->setApiConnectTimeOut(60)
            ->setUserDomain('test')
            ->setUserName('tester')
            ->setUserPassword('dev');
        $this->assertEquals('https', $this->config->getApiUrlScheme());
        $this->assertEquals('bpmonline.com', $this->config->getApiDomain());
        $this->assertEquals(60, $this->config->getApiConnectTimeOut());
        $this->assertEquals('test', $this->config->getUserDomain());
        $this->assertEquals('tester', $this->config->getUserName());
        $this->assertEquals('dev', $this->config->getUserPassword());
    }
}
