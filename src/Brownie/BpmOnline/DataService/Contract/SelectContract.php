<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Contract;

use Brownie\BpmOnline\DataService\Column\ColumnExpression;
use Brownie\BpmOnline\DataService\Contract;
use Brownie\BpmOnline\DataService\Column\ColumnFilter;

/**
 * SelectContract Data Contract.
 */
class SelectContract extends Contract
{

    /**
     * A collection of columns for readable records.
     *
     * @var array
     */
    private $columns = [];

    /**
     * Column filter.
     *
     * @var ColumnFilter
     */
    private $filter = null;

    /**
     * Flag of selection of all columns.
     *
     * @var bool
     */
    private $isAllColumns = false;

    /**
     * Flag of pagination.
     *
     * @var bool
     */
    private $isPageable = false;

    /**
     * Flag of uniqueness.
     *
     * @var bool
     */
    private $isDistinct = false;

    /**
     * Number of records selected.
     *
     * @var int
     */
    private $rowCount = -1;

    /**
     * Sets the input values.
     *
     * @param string $rootSchemaName The name of the root schema object.
     */
    public function __construct($rootSchemaName)
    {
        parent::__construct([
            'rootSchemaName' => $rootSchemaName,
            'operationType' => Contract::SELECT,
            'contractType' => Contract::SELECT_QUERY,
        ]);
    }

    /**
     * Sets the flag for selecting all columns.
     * Returns the current object.
     *
     * @param bool $isAllColumns Flag of selection of all columns.
     *
     * @return self
     */
    public function setIsAllColumns($isAllColumns)
    {
        $this->isAllColumns = (bool)$isAllColumns;
        return $this;
    }

    /**
     * Returns the flag for selecting all columns.
     *
     * @return bool
     */
    private function isAllColumns()
    {
        return $this->isAllColumns;
    }

    /**
     * Sets the pagination flag.
     * Returns the current object.
     *
     * @param bool $isPageable Flag of pagination.
     *
     * @return self
     */
    public function setIsPageable($isPageable)
    {
        $this->isPageable = $isPageable;
        return $this;
    }

    /**
     * Returns the pagination attribute.
     *
     * @return bool
     */
    private function isPageable()
    {
        return $this->isPageable;
    }

    /**
     * Sets flag of uniqueness.
     * Returns the current object.
     *
     * @param bool $isDistinct Flag of uniqueness.
     *
     * @return self
     */
    public function setIsDistinct($isDistinct)
    {
        $this->isDistinct = $isDistinct;
        return $this;
    }

    /**
     * Returns flag of uniqueness.
     *
     * @return bool
     */
    private function isDistinct()
    {
        return $this->isDistinct;
    }

    /**
     * Sets number of records selected.
     * Returns the current object.
     *
     * @param int $rowCount Number of records selected.
     *
     * @return self
     */
    public function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
        return $this;
    }

    /**
     * Return number of records selected.
     *
     * @return int
     */
    private function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * Adding a query expression to a contract.
     * Returns the current object.
     *
     * @param string            $name               Column name.
     * @param mixed             $orderDirection     The sort order.
     * @param int               $orderPosition      Column position.
     * @param string            $caption            Headline.
     * @param ColumnExpression  $columnExpression   Query expression to the schema object.
     *
     * @return self
     */
    public function addColumn($name, $orderDirection, $orderPosition, $caption, ColumnExpression $columnExpression)
    {
        $this->columns[$name] = [
            'OrderDirection' => $orderDirection,
            'OrderPosition' => $orderPosition,
            'Caption' => $caption,
            'Expression' => $columnExpression,
        ];
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
        $columns = [];
        foreach ($this->columns as $name => $columnData) {
            $columns[$name] = [
                'OrderDirection' => $columnData['OrderDirection'],
                'OrderPosition' => $columnData['OrderPosition'],
                'Caption' => $columnData['Caption'],
                'Expression' => $columnData['Expression']->toArray(),
            ];
        }
        $data = [
            'RootSchemaName' => $this->getRootSchemaName(),
            'OperationType' => $this->getOperationType(),
            'Columns' => [
                'Items' => $columns
            ],
            'AllColumns' => $this->isAllColumns(),
            /*
            'ServerESQCacheParameters' => [
                'CacheLevel' => 0,
                'CacheGroup' => '',
                'CacheItemName' => '',
            ],
            */
            'IsPageable' => $this->isPageable(),
            'IsDistinct' => $this->isDistinct(),
            'RowCount' => $this->getRowCount(),
            //'ConditionalValues' => null,
            //'IsHierarchical' => false,
            //'HierarchicalMaxDepth' => 0,
            //'HierarchicalColumnName' => '',
            //'HierarchicalColumnValue' => '',

        ];
        if (!empty($this->filter)) {
            $data['Filters'] = $this->filter->toArray();
        }
        return $data;
    }

    /**
     * Validates contract data, throws an exception in case of an error.
     */
    public function validate()
    {
    }
}
