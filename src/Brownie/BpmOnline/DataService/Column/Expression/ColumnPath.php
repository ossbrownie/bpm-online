<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression;

/**
 * @method string getValue() Returns column path.
 */
class ColumnPath extends Expression
{

    protected $keyName = 'ColumnPath';

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        'value' => null,
    ];

    /**
     * Sets the input values.
     *
     * @param string $value Column path.
     */
    public function __construct($value)
    {
        parent::__construct([
            'value' => $value
        ]);
    }
}
