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
 * Common response class when requesting contract execution.
 *
 * @method string   getRawResponse()                    Returns raw response body.
 * @method Response setJsonResponse($jsonResponse)      Sets json response.
 * @method array    getJsonResponse()                   Returns json response.
 */
class Response extends StorageArray
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        /**
         * Raw response.
         */
        'rawResponse' => '',

        /**
         * Json response.
         */
        'jsonResponse' => null,
    ];

    /**
     * Sets the input values.
     *
     * @param string    $rawResponse    Raw response.
     */
    public function __construct($rawResponse)
    {
        parent::__construct([
            'rawResponse' => $rawResponse
        ]);
    }

    /**
     * Parse response contract execution.
     *
     * @throws ValidateException
     */
    private function parseResponse()
    {
        $jsonResponse = json_decode($this->getRawResponse(), true);
        if (JSON_ERROR_NONE != json_last_error())
        {
            throw new ValidateException(
                'Invalid response: ' . substr($this->getRawResponse(), 0, 30) . '...'
            );
        }
        $this->setJsonResponse($jsonResponse);
    }

    /**
     * Returns the value of the response contract execution.
     *
     * @param string    $valueName      Value name.
     *
     * @return mixed
     *
     * @throws ValidateException
     */
    protected function getRequestValue($valueName)
    {
        $this->parseResponse();
        $response = $this->getJsonResponse();
        if (!isset($response[$valueName])) {
            throw new ValidateException('Undefined request value name: ' . $valueName);
        }
        return $response[$valueName];
    }

    /**
     * Returns the number of records affected.
     *
     * @return int
     *
     * @throws ValidateException
     */
    public function getRowsAffected()
    {
        return $this->getRequestValue('rowsAffected');
    }

    /**
     * Returns the value of the nextPrcElReady field.
     *
     * @return bool
     *
     * @throws ValidateException
     */
    public function getNextPrcElReady()
    {
        return $this->getRequestValue('nextPrcElReady');
    }

    /**
     * Returns the value of the success field.
     *
     * @return bool
     *
     * @throws ValidateException
     */
    public function getSuccess()
    {
        return $this->getRequestValue('success');
    }

    /**
     * Returns error message.
     *
     * @throws ValidateException
     */
    public function getErrorMessage()
    {
        return $this->getRequestValue('responseStatus')['Message'];
    }
}
