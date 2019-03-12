<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Column\Expression;

/**
 * Specifies the value that will be contained in the added column.
 *
 * @method mixed[]      getArrayValue()                     Returns an array of column values.
 * @method bool         setArrayValue(array $values)        Sets an array of values column.
 * @method bool         getShouldSkipConvertion()           Returns the flag to skip the cast process.
 * @method Parameter    setShouldSkipConvertion($isSkip)    Sets the flag to skip the cast process.
 *                                                          for the Value property.
 * @method int          getDataValueType()                  Parameter data type.
 */
class Parameter extends Expression
{

    /**
     * Guid.
     */
    const GUID = 0;

    /**
     * Text.
     */
    const TEXT = 1;

    /**
     * Integer.
     */
    const INTEGER = 4;

    /**
     * Float.
     */
    const FLOAT = 5;

    /**
     * Money.
     */
    const MONEY = 6;

    /**
     * DateTime.
     */
    const DATE_TIME = 7;

    /**
     * Date.
     */
    const DATE = 8;

    /**
     * Time.
     */
    const TIME = 9;

    /**
     * Lookup.
     */
    const LOOKUP = 10;

    /**
     * Enum.
     */
    const ENUM = 11;

    /**
     * Boolean.
     */
    const BOOLEAN = 12;

    /**
     * Blob.
     */
    const BLOB = 13;

    /**
     * Image.
     */
    const IMAGE = 14;

    /**
     * ImageLookup.
     */
    const IMAGE_LOOKUP = 16;

    /**
     * Color.
     */
    const COLOR = 18;

    /**
     * Mapping.
     */
    const MAPPING = 26;

    /**
     * Key depending on the ExpressionType property.
     *
     * @var string
     */
    protected $keyName = 'Parameter';

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        'dataValueType' => self::TEXT,
        'value' => '',
        'arrayValue' => [],
        'shouldSkipConvertion' => false,
    ];

    /**
     * Sets the input values.
     *
     * @param mixed     $value          Value.
     * @param int       $valueType      Data value type.
     */
    public function __construct($value, $valueType = self::TEXT)
    {
        parent::__construct([
            'dataValueType' => $valueType,
            'value' => $value,
        ]);
    }

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function getValue()
    {
        $data = [
            'DataValueType' => $this->getDataValueType(),
            'Value' => parent::getValue(),
        ];
        if (is_array($this->getArrayValue()) && !empty($this->getArrayValue())) {
            $data['ArrayValue'] = $this->getArrayValue();
        }
        if (!empty($this->getShouldSkipConvertion())) {
            $data['ShouldSkipConvertion'] = true;
        }
        return $data;
    }
}
