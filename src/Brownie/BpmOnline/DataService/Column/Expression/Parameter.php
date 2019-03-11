<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column\Expression;

use Brownie\BpmOnline\DataService\Type\DataValueType;
use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\BpmOnline\DataService\Column\Expression;

/**
 * The Parameter class is defined in the Terrasoft.Nui.ServiceModel.DataContract namespace.
 *
 * @method bool         getArrayValue()                     Returns an array of column values.
 * @method bool         setArrayValue(array $values)        Sets an array of values column.
 * @method bool         getShouldSkipConvertion()           Returns the flag to skip the cast process.
 * @method Parameter    setShouldSkipConvertion($isSkip)    Sets the flag to skip the cast process.
 *                                                          for the Value property.
 */
class Parameter extends Expression
{

    const GUID = 0;

    const TEXT = 1;

    const INTEGER = 4;

    const FLOAT = 5;

    const MONEY = 6;

    const DATE_TIME = 7;

    const DATE = 8;

    const TIME = 9;

    const LOOKUP = 10;

    const ENUM = 11;

    const BOOLEAN = 12;

    const BLOB = 13;

    const IMAGE = 14;

    const IMAGE_LOOKUP = 16;

    const COLOR = 18;

    const MAPPING = 26;

    protected $keyName = 'Parameter';

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
     * Returns data as an associative array.
     *
     * @return array
     *
     * @throws ValidateException
     */
    public function getValue()
    {
        $data = [
            'DataValueType' => $this->getDataValueType(),
            'Value' => parent::getValue(),
        ];
        if (!empty($this->getArrayValue()) && is_array($this->getArrayValue())) {
            $data['ArrayValue'] = $this->getArrayValue();
        }
        if (!empty($this->getShouldSkipConvertion())) {
            $data['ShouldSkipConvertion'] = true;
        }
        return $data;
    }
}
