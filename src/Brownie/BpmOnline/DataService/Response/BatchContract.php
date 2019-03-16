<?php

/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Contract;
use Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\Exception\ValidateException;
/**
 * The response to the execution of the contract BatchContract.
 */
class BatchContract extends Response
{

    /**
     * Contracts.
     *
     * @var Contract[]
     */
    private $contracts = [];

    /**
     * Sets the input values.
     *
     * @param string    $rawResponse    Raw response.
     * @param array     $contracts      Contracts.
     */
    public function __construct($rawResponse, $contracts = [])
    {
        parent::__construct($rawResponse);
        $this->setContracts($contracts);
    }

    /**
     * Sets contracts.
     *
     * @param array $contracts Contracts
     *
     * @return self
     */
    private function setContracts(array $contracts)
    {
        $this->contracts = $contracts;
        return $this;
    }

    /**
     * Returns contracts.
     *
     * @return Contract[]
     */
    private function getContracts()
    {
        return $this->contracts;
    }

    /**
     * Returns responses.
     *
     * @return Response[]
     *
     * @throws ValidateException
     */
    public function getContractsResponse()
    {
        $responses = [];
        $queryResults = $this->getRequestValue('queryResults');
        /**
         * @var Contract $contract
         */
        foreach ($this->getContracts() as $index => $contract) {
            $responses[] = $contract->getResponse(json_encode($queryResults[$index]));
        }
        return $responses;
    }
}
