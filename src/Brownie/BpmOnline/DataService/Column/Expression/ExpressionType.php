<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression;

/**
 * The type of expression that determines the value that will be contained in the added column.
 */
class ExpressionType extends Expression
{

    /**
     * Scheme column.
     */
    const SCHEMA_COLUMN = 0;

    /**
     * Function.
     */
    const FUNCTION = 1;

    /**
     * Parameter.
     */
    const PARAMETER = 2;

    /**
     * Subquery.
     */
    const SUB_QUERY = 3;

    /**
     * Arithmetic operation.
     */
    const ARITHMETIC_OPERATION = 4;

    /**
     * Key depending on the ExpressionType property.
     *
     * @var string
     */
    protected $keyName = 'ExpressionType';

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        'value' => self::PARAMETER,
    ];

    /**
     * Sets the input values.
     *
     * @param string $value Expression type.
     */
    public function __construct($value)
    {
        parent::__construct([
            'value' => $value
        ]);
    }
}
