<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

/**
 * Base Interface for Expression Column.
 */
interface Column
{

    /**
     * Returns data as an associative array.
     *
     * @return array
     */
    public function toArray();
}
