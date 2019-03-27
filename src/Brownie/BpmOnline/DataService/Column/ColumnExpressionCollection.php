<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

/**
 * Collection of column expressions.
 */
class ColumnExpressionCollection implements Column
{

    /**
     * Column expression collection.
     *
     * @var ColumnExpression[]
     */
    private $columns;

    /**
     * Sets the input values.
     *
     * @param ColumnExpression[]    $columns    Column expression collection.
     */
    public function __construct(array $columns)
    {
        $this->setColumns($columns);
    }

    /**
     * Sets column expression collection.
     * Returns the current object.
     *
     * @param ColumnExpression[]    $columns    Column expression collection.
     *
     * @return self
     */
    private function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Gets column expression collection.
     *
     * @return ColumnExpression[]
     */
    private function getColumns()
    {
        return $this->columns;
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function($column) {
            return $column->toArray();
        }, $this->getColumns());
    }
}
