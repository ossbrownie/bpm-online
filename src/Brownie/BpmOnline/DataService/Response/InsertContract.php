<?php

/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Response;

use Brownie\BpmOnline\DataService\Response;
use Brownie\BpmOnline\Exception\ValidateException;

/**
 * The response to the execution of the contract InsertContract.
 */
class InsertContract extends Response
{

    /**
     * Returns the value of the id field.
     *
     * @return string
     *
     * @throws ValidateException
     */
    public function getId()
    {
        return $this->getRequestValue('id');
    }
}
