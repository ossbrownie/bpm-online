<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

use Brownie\Util\StorageArray;

/**
 * Base class for expressing a selectable column.
 */
class Expression extends StorageArray
{

    /**
     * Key depending on the ExpressionType property.
     *
     * @var null|string
     */
    protected $keyName = null;

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        'value' => null,
    ];

    /**
     * Returns a key depending on the ExpressionType property.
     *
     * @return string|null
     */
    public function getKeyName()
    {
        return $this->keyName;
    }

    /**
     * Returns the value of an expression depending on the ExpressionType property.
     *
     * @return mixed
     */
    public function getValue()
    {
        return parent::/** @scrutinizer ignore-call */getValue();
    }
}
