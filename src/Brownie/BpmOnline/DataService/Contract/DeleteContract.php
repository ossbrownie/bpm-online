<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Contract;
use Brownie\BpmOnline\DataService\Column\ColumnFilter;
use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\BpmOnline\DataService\Response\DeleteContract as ResponseDeleteContract;

/**
 * DeleteContract Data Contract.
 */
class DeleteContract extends Contract
{

    /**
     * Column filter.
     *
     * @var ColumnFilter
     */
    private $filter;

    /**
     * Sets the input values.
     *
     * @param string $rootSchemaName The name of the root schema object.
     */
    public function __construct($rootSchemaName)
    {
        parent::__construct([
            'rootSchemaName' => $rootSchemaName,
            'operationType' => Contract::DELETE,
            'contractType' => Contract::DELETE_QUERY,
        ]);
    }

    /**
     * Adding query filter to contract.
     *
     * @param ColumnFilter $columnFilter Column filter.
     *
     * @return self
     */
    public function addFilter(ColumnFilter $columnFilter)
    {
        $this->filter = $columnFilter;
        return $this;
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $filter = [];
        if (!empty($this->filter)) {
            $filter = $this->filter->toArray();
        }
        return [
            'RootSchemaName' => $this->getRootSchemaName(),
            'OperationType' => $this->getOperationType(),
            'Filters' => $filter,
        ];
    }

    /**
     * Validates contract data, throws an exception in case of an error.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if ((3 != $this->getOperationType()) || empty($this->filter)) {
            throw new ValidateException('Invalid contract arguments.');
        }
        $this->filter->validate();
    }

    /**
     * Returns the response of the performance contract.
     *
     * @param string    $rawResponse    Raw response.
     *
     * @return ResponseDeleteContract
     */
    public function getResponse($rawResponse)
    {
        return new ResponseDeleteContract($rawResponse);
    }
}
