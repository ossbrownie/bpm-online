<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline\Util;

/**
 * The class DateTime for the formation of time in the requests.
  */
class DateTime
{

    /**
     * Timestamp in queries.
     *
     * @var int  $dateTime
     */
    private $dateTime;

    /**
     * Sets the input values.
     *
     * @param null|int|string   $dateTime   Time in queries.
     */
    public function __construct($dateTime = null)
    {
        if (empty($dateTime)) {
            $dateTime = time();
        }
        $this->dateTime = $dateTime;
        if (!is_numeric($dateTime)) {
            $this->dateTime = strtotime($dateTime);
        }
    }

    /**
     * Returns the time as a string to pass to bpm'online.
     *
     * @return string
     */
    public function __toString()
    {
        return '"' . date('c', $this->dateTime) . '"';
    }
}
