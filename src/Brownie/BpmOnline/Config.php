<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline;

use Brownie\Util\StorageArray;

/**
 * Bpm’online configuration.
 *
 * @method string   getApiUrlScheme()           Returns the scheme of the request to API.
 * @method string   getApiDomain()              Returns API domain
 * @method int      getApiConnectTimeOut()      Returns the allowed number of seconds to execute requests to the API.
 * @method string   getUserDomain()             Returns the domain of the user bpm'online.
 * @method string   getUserName()               Returns the login of the user bpm'online.
 * @method string   getUserPassword()           Returns the password of the user bpm'online.
 */
class Config extends StorageArray
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        /**
         * URL scheme.
         */
        'apiUrlScheme' => 'https',

        /**
         * CRM domain.
         */
        'apiDomain' => 'bpmonline.com',

        /**
         * Timeout for requests to API.
         */
        'apiConnectTimeOut' => 60,

        /**
         * Sub user domain.
         */
        'userDomain' => 'test',

        /**
         * User name.
         */
        'userName' => 'tester',

        /**
         * User password.
         */
        'userPassword' => 'dev',
    ];
}
