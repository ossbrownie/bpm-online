<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\BpmOnline\DataService\Contract;
use Brownie\BpmOnline\DataService\Response\InsertContract as ResponseInsertContract;

/**
 * InsertContract Data Contract.
 */
class InsertContract extends Contract
{

    private $dictionary = [];

    /**
     * Sets the input values.
     *
     * @param string $rootSchemaName The name of the root schema object.
     */
    public function __construct($rootSchemaName)
    {
        parent::__construct([
            'rootSchemaName' => $rootSchemaName,
            'operationType' => Contract::INSERT,
            'contractType' => Contract::INSERT_QUERY,
        ]);
    }

    /**
     * Adds a ColumnExpression object to the dictionary collection.
     * Returns the current object.
     *
     * @param string            $name               The name of the column.
     * @param ColumnExpression  $columnExpression   Query expression to the schema object.
     *
     * @return self
     */
    public function addColumn($name, ColumnExpression $columnExpression)
    {
        $this->dictionary[$name] = $columnExpression;
        return $this;
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $dictionary = [];
        /**
         * @var ColumnExpression $columnExpression
         */
        foreach ($this->dictionary as $keyName => $columnExpression) {
            $dictionary[$keyName] = $columnExpression->toArray();
        }
        return [
            'RootSchemaName' => $this->getRootSchemaName(),
            'OperationType' => $this->getOperationType(),
            'ColumnValues' => [
                'Items' => $dictionary
            ]
        ];
    }

    /**
     * Validates contract data, throws an exception in case of an error.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if ((1 != $this->getOperationType()) || empty($this->dictionary)) {
            throw new ValidateException('Invalid contract arguments.');
        }
    }

    /**
     * Returns the response of the performance contract.
     *
     * @param string    $rawResponse    Raw response.
     *
     * @return ResponseInsertContract
     */
    public function getResponse($rawResponse)
    {
        return new ResponseInsertContract($rawResponse);
    }
}
