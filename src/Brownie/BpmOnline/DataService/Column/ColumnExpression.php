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
class ColumnExpression implements Column
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
        $this->setExpressions(func_get_args());
    }

    /**
     * Sets collection of expressions.
     * Returns the current object.
     *
     * @param array     $expressions    Collection of expressions.
     *
     * @return self
     */
    private function setExpressions(array $expressions)
    {
        $this->expressions = $expressions;
        return $this;
    }

    /**
     * Gets collection of expressions.
     *
     * @return Expression[]
     */
    private function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $expressions = [];
        foreach ($this->getExpressions() as $expression) {
            $expressions[$expression->getKeyName()] = $expression->getValue();
        }
        return $expressions;
    }
}
