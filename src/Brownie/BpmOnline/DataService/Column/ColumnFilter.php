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
     * Filter type not set.
     */
    const FILTER_NONE = 0;

    /**
     * Comparison filter.
     */
    const FILTER_COMPARE = 1;

    /**
     * A filter that checks if the test expression is empty or not empty.
     */
    const FILTER_IS_NULL = 2;

    /**
     * A filter that checks if the expression to be tested falls within the range of expressions.
     */
    const FILTER_BETWEEN = 3;

    /**
     * A filter that checks if the test expression is equal to one of the expressions.
     */
    const FILTER_IN = 4;

    /**
     * The filter "Exists according to the set condition".
     */
    const FILTER_EXISTS = 5;

    /**
     * Filter ser.
     */
    const FILTER_FILTER_GROUP = 6;

    /* COMPARISON */

    /**
     * Checks if the value falls within the range of values.
     */
    const COMPARISON_BETWEEN = 0;

    /**
     * Checks whether the value is empty.
     */
    const COMPARISON_IS_NULL = 1;

    /**
     * Checks that the value is not empty.
     */
    const COMPARISON_IS_NOT_NULL = 2;

    /**
     * Checks for equality of values.
     */
    const COMPARISON_EQUAL = 3;

    /**
     * Checks for inequality of values.
     */
    const COMPARISON_NOT_EQUAL = 4;

    /**
     * Checks that the value is less.
     */
    const COMPARISON_LESS = 5;

    /**
     * Checks that the value is less than or equal to.
     */
    const COMPARISON_LESS_OR_EQUAL = 6;

    /**
     * Checks that the value is greater.
     */
    const COMPARISON_GREATER = 7;

    /**
     * Verifying that the value is greater than or equal to.
     */
    const COMPARISON_GREATER_OR_EQUAL = 8;

    /**
     * Checks if the value starts with the search string.
     */
    const COMPARISON_START_WITH = 9;

    /**
     * Checks if the value does not start with the search string.
     */
    const COMPARISON_NO_START_WITH = 10;

    /**
     * Checks if the value includes the search string.
     */
    const COMPARISON_CONTAIN = 11;

    /**
     * Checks if the value does not include the search string.
     */
    const COMPARISON_NOT_CONTAIN = 12;

    /**
     * Checks if the value ends with the search string.
     */
    const COMPARISON_END_WITH = 13;

    /**
     * Checks if the value does not end with the search string.
     */
    const COMPARISON_NO_END_WITH = 14;

    /**
     * Exists according to the given condition.
     */
    const COMPARISON_EXISTS = 15;

    /**
     * Does not exist according to the given condition.
     */
    const COMPARISON_NOT_EXISTS = 16;

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
     * @param int           $filterType         Filter type.
     * @param int           $comparisonType     Comparison Type.
     * @param Column|null   $_                  Column expressions.
     */
    public function __construct($filterType, $comparisonType, Column $_ = null)
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
            case self::FILTER_IN:
                $data['LeftExpression'] = $this->getColumnExpressions()[0]->toArray();
                $data['RightExpressions'] = $this->getColumnExpressions()[1]->toArray();
                break;
            case self::FILTER_COMPARE:
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
        if (
            ($this->getFilterType() < self::FILTER_NONE) ||
            ($this->getFilterType() > self::FILTER_FILTER_GROUP)
        ) {
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
        if (
            ($this->getComparisonType() < self::COMPARISON_BETWEEN) ||
            ($this->getComparisonType() > self::COMPARISON_NOT_EXISTS)
        ) {
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
            (self::FILTER_BETWEEN != $this->getFilterType()) &&
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
