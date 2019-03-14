<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\Util\StorageArray;

/**
 * Filter for contracts.
 *
 * @method int      getFilterType()             Returns the type of filter.
 * @method int      getComparisonType()         Returns the type of comparison.
 * @method array    getColumnExpressions()      Returns column expressions.
 */
class ColumnFilter extends StorageArray
{

    /* FILTER */

    /**
     * Filter type not defined.
     */
    const FILTER_NONE = 0;

    /**
     * Comparison filter.
     */
    const FILTER_COMPARE_FILTER = 1;

    /**
     * A filter that determines whether the expression being tested is empty or not.
     */
    //const FILTER_IS_NULL_FILTER = 2;

    /**
     * A filter that checks if the expression being checked is in the range of expressions.
     */
    const FILTER_BETWEEN = 3;

    /**
     * A filter that checks whether the expression being tested is equal to one of the expressions.
     */
    //const FILTER_IN_FILTER = 4;

    /**
     * Filter existence by a given field.
     */
    //const FILTER_EXISTS = 5;

    /**
     * Filter group.
     */
    //const FILTER_FILTER_GROUP = 6;

    /* COMPARISON */

    /**
     * Value range.
     */
    const COMPARISON_BETWEEN = 0;

    /**
     * Equally.
     */
    const COMPARISON_EQUAL = 3;

    /**
     * Not equal.
     */
    const COMPARISON_NOT_EQUAL = 4;

    /**
     * Starts with an expression.
     */
    const COMPARISON_START_WITH = 9;

    /**
     * Does not start with an expression.
     */
    const COMPARISON_NO_START_WITH = 10;

    /**
     * Contains an expression.
     */
    const COMPARISON_CONTAIN = 11;

    /**
     * Does not contain an expression.
     */
    const COMPARISON_NOT_CONTAIN = 12;

    /**
     * Ends expression.
     */
    const COMPARISON_END_WITH = 13;

    /**
     * Does not end with an expression.
     */
    const COMPARISON_NO_END_WITH = 14;

    /**
     * More.
     */
    //const COMPARISON_GREATER = -1;

    /**
     * More or equal.
     */
    //const COMPARISON_GREATER_OR_EQUAL = -1;

    /**
     * Less.
     */
    //const COMPARISON_LESS = -1;

    /**
     * Less or equal.
     */
    //const COMPARISON_LESS_OR_EQUAL = -1;



    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        'filterType' => null,
        'comparisonType' => null,
        'columnExpressions' => [],
    ];

    /**
     * Sets the input values.
     *
     * @param int                       $filterType         Filter type.
     * @param int                       $comparisonType     Comparison Type.
     * @param ColumnExpression|null     $_                  Column expressions.
     */
    public function __construct($filterType, $comparisonType, ColumnExpression $_ = null)
    {
        parent::__construct([
            'filterType' => $filterType,
            'comparisonType' => $comparisonType,
            'columnExpressions' => array_slice(func_get_args(), 2),
        ]);
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'FilterType' => $this->getFilterType(),
            'ComparisonType' => $this->getComparisonType(),
        ];
        switch ($this->getFilterType()) {
            case self::FILTER_COMPARE_FILTER:
                $data['LeftExpression'] = $this->getColumnExpressions()[0]->toArray();
                $data['RightExpression'] = $this->getColumnExpressions()[1]->toArray();
                break;
            case self::FILTER_BETWEEN:
                $data['LeftExpression'] = $this->getColumnExpressions()[0]->toArray();
                $data['RightLessExpression'] = $this->getColumnExpressions()[1]->toArray();
                $data['RightGreaterExpression'] = $this->getColumnExpressions()[2]->toArray();
                break;
        }
        return $data;
    }

    /**
     * Validates filter data, throws an exception in case of an error.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        $this->checkFilterType();
        $this->checkComparisonType();
        $this->checkCompareColumnExpressions();
        $this->checkBetweenColumnExpressions();
    }

    /**
     * Filter type check.
     *
     * @throws ValidateException
     */
    private function checkFilterType()
    {
        if (!in_array(
            $this->getFilterType(),
            [
                self::FILTER_COMPARE_FILTER,
                self::FILTER_BETWEEN
            ]
        )) {
            throw new ValidateException('Invalid filter.');
        }
    }

    /**
     * Verification of the comparison method.
     *
     * @throws ValidateException
     */
    private function checkComparisonType()
    {
        if (!in_array(
            $this->getComparisonType(),
            [
                self::COMPARISON_EQUAL,
                self::COMPARISON_BETWEEN
            ]
        )) {
            throw new ValidateException('Invalid filter compare arguments.');
        }
    }

    /**
     * Checking expressions for comparing values.
     *
     * @throws ValidateException
     */
    private function checkCompareColumnExpressions()
    {
        if (
            (self::FILTER_COMPARE_FILTER == $this->getFilterType()) &&
            (2 != count($this->getColumnExpressions()))
        ) {
            throw new ValidateException('Invalid filter_compare count column expressions.');
        }
    }

    /**
     * Checking expressions for between values.
     *
     * @throws ValidateException
     */
    private function checkBetweenColumnExpressions()
    {
        if (
            (self::FILTER_BETWEEN == $this->getFilterType()) &&
            (3 != count($this->getColumnExpressions()))
        ) {
            throw new ValidateException('Invalid filter_between count column expressions.');
        }
    }
}
