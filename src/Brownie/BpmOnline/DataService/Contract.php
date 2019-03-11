<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService;

use Brownie\BpmOnline\Exception\ValidateException;
use Brownie\Util\StorageArray;

/**
 * Common class for contract query.
 *
 * @method string       getRootSchemaName()                 Sets the name of the root object schema.
 * @method Contract     setRootSchemaName($rootSchemaName)  Returns the name of the root object schema.
 * @method int          getOperationType()                  Returns the type of operation with a record.
 * @method Contract     setOperationType($operationType)    Sets the type of operation with the entry.
 * @method string       getContractType()                   Returns the type of the contract.
 * @method Contract     setContractType($contractType)      Sets the contract type.
 */
class Contract extends StorageArray
{
    /**
     * Type of operation with record SELECT for sampling data.
     */
    const SELECT = 0;

    /**
     * Type of operation with record INSERT to insert data.
     */
    const INSERT = 1;

    /**
     * Type of operation with record UPDATE to update the data.
     */
    const UPDATE = 2;

    /**
     * Type of operation with record DELETE to delete data.
     */
    const DELETE = 3;

    /**
     * Type of operation with record BATCH for group queries.
     */
    //const BATCH = 4;

    /**
     * The endpoint for the SELECT operation.
     */
    const SELECT_QUERY = 'SelectQuery';

    /**
     * The endpoint for the INSERT operation.
     */
    const INSERT_QUERY = 'InsertQuery';

    /**
     * The endpoint for the UPDATE operation.
     */
    const UPDATE_QUERY = 'UpdateQuery';

    /**
     * The endpoint for the DELETE operation.
     */
    const DELETE_QUERY = 'DeleteQuery';

    /**
     * The endpoint for the BATCH operation.
     */
    //const BATCH_QUERY = 'BatchQuery';

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        /**
         * The name of the root schema object.
         */
        'rootSchemaName' => '',

        /**
         * Record operation type.
         */
        'operationType' => null,

        /**
         * Determination of the contract to fulfill the request in the API.
         */
        'contractType' => null,
    ];

    /**
     * Validates contract data, throws an exception in case of an error.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        throw new ValidateException('Invalid contract arguments.');
    }
}
