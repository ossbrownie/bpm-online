<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Contract;
use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\BpmOnline\DataService\Response\BatchContract as ResponseBranchContract;

/**
 * BatchContract Data Contract.
 */
class BatchContract extends Contract
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
     * BatchContract constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'operationType' => Contract::BATCH,
            'contractType' => Contract::BATCH_QUERY,
        ]);
    }

    /**
     * Adding contract.
     *
     * @param Contract $contract Contract.
     *
     * @return self
     */
    public function addContract(Contract $contract)
    {
        $this->contracts[] = $contract;
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
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $items = [];
        foreach ($this->getContracts() as $index => $contract) {
            $items[] = array_merge(
                ['__type' => 'Terrasoft.Nui.ServiceModel.DataContract.' . $contract->getContractType()],
                $contract->toArray()
            );
        }
        return [
            'items' => $items
        ];
    }

    /**
     * Validates contract data, throws an exception in case of an error.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if (empty($this->getContracts())) {
            throw new ValidateException('Invalid contract arguments.');
        }
    }

    /**
     * Returns the response of the performance contract.
     *
     * @param string    $rawResponse    Raw response.
     *
     * @return ResponseBranchContract
     */
    public function getResponse($rawResponse)
    {
        return new ResponseBranchContract($rawResponse, $this->getContracts());
    }
}
