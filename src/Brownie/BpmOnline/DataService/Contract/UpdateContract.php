<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Contract;
use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Column\ColumnFilter;
use Brownie\BpmOnline\Exception\ValidateException;

/**
 * UpdateContract Data Contract.
 */
class UpdateContract extends Contract
{

    /**
     * The collection of column values for the entry being added.
     *
     * @var array
     */
    private $dictionary = [];

    /**
     * Column filter.
     *
     * @var ColumnFilter
     */
    private $filter = null;

    /**
     * Sets the input values.
     *
     * @param string $rootSchemaName The name of the root schema object.
     */
    public function __construct($rootSchemaName)
    {
        parent::__construct([
            'rootSchemaName' => $rootSchemaName,
            'operationType' => Contract::UPDATE,
            'contractType' => Contract::UPDATE_QUERY,
        ]);
    }

    /**
     * Adding a query expression to a contract.
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
        $dictionary = [];
        /**
         * @var ColumnExpression $columnExpression
         */
        foreach ($this->dictionary as $keyName => $columnExpression) {
            $dictionary[$keyName] = $columnExpression->toArray();
        }
        $filter = [];
        if (!empty($this->filter)) {
            $filter = $this->filter->toArray();
        }
        return [
            'RootSchemaName' => $this->getRootSchemaName(),
            'OperationType' => $this->getOperationType(),
            'IsForceUpdate' => false,
            'ColumnValues' => [
                'Items' => $dictionary
            ],
            'Filters' => $filter
        ];
    }

    /**
     * Validates contract data, throws an exception in case of an error.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if (empty($this->filter)) {
            throw new ValidateException('Invalid contract arguments.');
        }
        $this->filter->validate();
    }
}
