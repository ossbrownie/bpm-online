<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\DataService\Column;

use Brownie\Util\StorageArray;

class Expression extends StorageArray
{

    protected $keyName = null;

    public function getKeyName()
    {
        return $this->keyName;
    }

    public function getValue()
    {
        return $this->toArray();
    }
}
