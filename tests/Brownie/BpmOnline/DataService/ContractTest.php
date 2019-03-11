<?php

namespace Test\Brownie\BpmOnline\DataService;

use PHPUnit\Framework\TestCase;
use Brownie\BpmOnline\DataService\Contract;

class ContractTest extends TestCase
{

    /**
     * @var Contract
     */
    private $contract;

    protected function setUp()
    {
        $this->contract = new Contract();
    }

    protected function tearDown()
    {
        $this->contract = null;
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this->contract->validate();
    }

    public function testSetGetRootSchemaName()
    {
        $this->contract->setRootSchemaName('TestRootSchemaName');
        $this->assertEquals('TestRootSchemaName', $this->contract->getRootSchemaName());
    }

    public function testSetGetOperationType()
    {
        $this->contract->setOperationType('TestOperationType');
        $this->assertEquals('TestOperationType', $this->contract->getOperationType());
    }

    public function testSetGetContractType()
    {
        $this->contract->setContractType('TestContractType');
        $this->assertEquals('TestContractType', $this->contract->getContractType());
    }
}
