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
use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\BpmOnline\DataService\Response\SelectContract as ResponseSelectContract;

/**
 * SelectContract Data Contract.
 *
 * @method bool             getIsAllColumns()               Returns the flag for selecting all columns.
 * @method SelectContract   setIsAllColumns($isAllColumns)  Sets the flag for selecting all columns.
 * @method bool             getIsPageable()                 Returns the pagination attribute.
 * @method SelectContract   setIsPageable($isPageable)      Sets the pagination flag.
 * @method bool             getIsDistinct()                 Returns flag of uniqueness.
 * @method SelectContract   setIsDistinct($isDistinct)      Sets flag of uniqueness.
 * @method int              getRowCount()                   Return number of records selected.
 * @method SelectContract   setRowCount($rowCount)          Sets number of records selected.
 * @method int              getRowsOffset()                 Returns the number of rows to skip when
 *                                                          returning a query result.
 * @method SelectContract   setRowsOffset($rowsOffset)      Sets the number of lines to skip when
 *                                                          returning a query result.
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
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        /**
         * The name of the root schema object.
         */
        'rootSchemaName' => '',

        /**
         * Record operation type.
         */
        'operationType' => null,

        /**
         * Determination of the contract to fulfill the request in the API.
         */
        'contractType' => null,

        /**
         * Flag of selection of all columns.
         */
        'isAllColumns' => false,

        /**
         *  Flag of pagination.
         */
        'isPageable' => false,

        /**
         * Flag of uniqueness.
         */
        'isDistinct' => false,

        /**
         * Number of records selected.
         */
        'rowCount' => -1,

        /**
         * The number of rows to skip when returning a query result.
         */
        'rowsOffset' => 0,
    ];

    /**
     * Sets the input values.
     *
     * @param string $rootSchemaName The name of the root schema object.
     */
    public function __construct($rootSchemaName)
    {
        parent::__construct([
            /**
             * A string containing the name of the object's root schema for the entry to be added.
             */
            'rootSchemaName' => $rootSchemaName,

            /**
             * The type of operation with the record.
             */
            'operationType' => Contract::SELECT,

            /**
             * Contract type.
             */
            'contractType' => Contract::SELECT_QUERY,
        ]);
    }

    /**
     * Adding a query expression to a contract.
     * Returns the current object.
     *
     * @param string            $name               Column name.
     * @param string            $caption            Headline.
     * @param ColumnExpression  $columnExpression   Query expression to the schema object.
     * @param string            $orderDirection     The sort order.
     * @param int               $orderPosition      Column position.
     *
     * @return self
     */
    public function addColumn(
        $name,
        $caption,
        ColumnExpression $columnExpression,
        $orderDirection = 'asc',
        $orderPosition = 0
    ) {
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
            'AllColumns' => $this->getIsAllColumns(),
            /*
            'ServerESQCacheParameters' => [
                'CacheLevel' => 0,
                'CacheGroup' => '',
                'CacheItemName' => '',
            ],
            */
            'IsPageable' => $this->getIsPageable(),
            'IsDistinct' => $this->getIsDistinct(),
            'RowCount' => $this->getRowCount(),
            'RowsOffset' => $this->getRowsOffset(),
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
     *
     * @throws ValidateException
     */
    public function validate()
    {
        if (0 != $this->getOperationType()) {
            throw new ValidateException('Invalid contract arguments.');
        }
    }

    /**
     * Returns the response of the performance contract.
     *
     * @param string    $rawResponse    Raw response.
     *
     * @return ResponseSelectContract
     */
    public function getResponse($rawResponse)
    {
        return new ResponseSelectContract($rawResponse);
    }
}
