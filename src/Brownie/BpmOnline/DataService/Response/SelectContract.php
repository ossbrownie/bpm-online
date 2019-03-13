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
 * The response to the execution of the contract SelectContract.
 */
class SelectContract extends Response
{

    /**
     * Returns the value of the rowConfig field.
     *
     * @return string
     *
     * @throws ValidateException
     */
    public function getRowConfig()
    {
        return $this->getRequestValue('rowConfig');
    }

    /**
     * Returns the value of the rows field.
     *
     * @return string
     *
     * @throws ValidateException
     */
    public function getRows()
    {
        return $this->getRequestValue('rows');
    }
}
