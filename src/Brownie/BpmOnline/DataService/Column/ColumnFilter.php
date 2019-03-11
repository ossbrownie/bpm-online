<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\Util\StorageArray;

class ColumnFilter extends StorageArray
{

    const FILTER_NONE = 0;

    const FILTER_COMPARE_FILTER = 1;

    //const FILTER_IS_NULL_FILTER = 2;

    const FILTER_BETWEEN = 3;

    //const FILTER_IN_FILTER = 4;

    //const FILTER_EXISTS = 5;

    //const FILTER_FILTER_GROUP = 6;

    // WTF?

    const COMPARISON_NONE = 0;

    const COMPARISON_EQUAL = 0;

    //const COMPARISON_NOT_EQUAL = 0;

    const COMPARISON_BETWEEN = 0;

    //const COMPARISON_START_WITH = 0;

    //const COMPARISON_END_WITH = 0;

    //const COMPARISON_GREATER = 0;

    //const COMPARISON_GREATER_OR_EQUAL = 0;

    //const COMPARISON_LESS = 0;

    //const COMPARISON_LESS_OR_EQUAL = 0;

    //const COMPARISON_CONTAIN = 0;
    
    //const COMPARISON_NOT_CONTAIN = 0;

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

    public function __construct($filterType, $comparisonType, ColumnExpression $_ = null)
    {
        parent::__construct([
            'filterType' => $filterType,
            'comparisonType' => $comparisonType,
            'columnExpressions' => array_slice(func_get_args(), 2),
        ]);
    }

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

    public function validate()
    {
        if (!in_array($this->getFilterType(), [
            self::FILTER_COMPARE_FILTER,
            self::FILTER_BETWEEN
        ])) {
            throw new ValidateException('Invalid filter.');
        }
        if (!in_array($this->getComparisonType(), [
            self::COMPARISON_EQUAL,
            self::COMPARISON_BETWEEN
        ])) {
            throw new ValidateException('Invalid filter compare arguments.');
        }
        if ((self::FILTER_COMPARE_FILTER == $this->getFilterType()) && (2 != count($this->getColumnExpressions()))) {
            throw new ValidateException('Invalid count column expressions.');
        }
        if ((self::FILTER_BETWEEN == $this->getFilterType()) && (3 != count($this->getColumnExpressions()))) {
            throw new ValidateException('Invalid count column expressions.');
        }
    }
}
