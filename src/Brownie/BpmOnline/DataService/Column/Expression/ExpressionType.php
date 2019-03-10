<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression;

class ExpressionType extends Expression
{

    const SCHEMA_COLUMN = 0;

    const FUNCTION = 1;

    const PARAMETER = 2;

    const SUB_QUERY = 3;

    const ARITHMETIC_OPERATION = 4;

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
