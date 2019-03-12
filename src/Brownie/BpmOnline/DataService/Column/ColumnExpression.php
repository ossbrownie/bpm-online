<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

/**
 * An expression defining a column type.
 */
class ColumnExpression
{

    /**
     * Collection of expressions.
     *
     * @var Expression[]
     */
    private $expressions = [];

    /**
     * Sets the input values.
     *
     * @param Expression|null   $_      Collection of expressions.
     */
    public function __construct(Expression $_ = null)
    {
        $this->expressions = func_get_args();
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $expressions = [];
        foreach ($this->expressions as $expression) {
            $expressions[$expression->getKeyName()] = $expression->getValue();
        }
        return $expressions;
    }
}
