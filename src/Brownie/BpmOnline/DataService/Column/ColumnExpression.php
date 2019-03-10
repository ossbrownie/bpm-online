<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

class ColumnExpression
{

    private $columnExpressions = [];

    public function __construct(Expression $_ = null)
    {
        $this->columnExpressions[] = func_get_args();
    }

    public function toArray()
    {
        $expressions = [];
        /**
         * @var Expression $expression
         */
        foreach ($this->columnExpressions as $expression) {
            $expressions[$expression->getKeyName()] = $expression->getValue();
        }
        return $expressions;
    }
}
