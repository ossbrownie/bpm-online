<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline;

use Brownie\BpmOnline\Exception\AuthenticationException;
use Brownie\HttpClient\HTTPClient;
use Brownie\BpmOnline\DataService\Contract;
use Brownie\HttpClient\Request;
use Brownie\Util\StorageArray;

/**
 * @method BpmOnline    setHttpClient($httpClient)
 * @method HTTPClient   getHttpClient()
 * @method BpmOnline    setConfig($config)
 * @method Config       getConfig()
 * @method BpmOnline    setConfigurationNumber($configurationNumber)
 * @method int          getConfigurationNumber()
 * @method BpmOnline    setDataFormat($dataFormat)
 * @method string       getDataFormat()
 */
class BpmOnline extends StorageArray
{

    /**
     * List of supported fields.
     *
     * @var array
     */
    protected $fields = [
        'httpClient' => null,
        'config' => null,
        'configurationNumber' => 0,
        'dataFormat' => 'json',
        'authentication' => null,
    ];

    public function __construct(HTTPClient $httpClient, Config $config)
    {
        parent::__construct([
            'httpClient' => $httpClient,
            'config' => $config,
        ]);
    }

    private function authentication()
    {
        $request = new Request();
        $request
            ->setMethod(Request::HTTP_METHOD_POST)
            ->setUrl(
                $this->getConfig()->getApiUrlScheme() . '://' .
                //$this->getConfig()->getUserDomain() . '.' .
                'www.' . $this->getConfig()->getApiDomain() .
                '/ServiceModel/AuthService.svc/Login'
            )
            ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
            ->setBody(json_encode([
                'UserName' => $this->getConfig()->getUserName(),
                'UserPassword' => $this->getConfig()->getUserPassword(),
            ]))
            ->setTimeOut($this->getConfig()->getApiConnectTimeOut());

        $response = $this->getHttpClient()->request($request);

        if (200 == $response->getHttpCode()) {
            $this->setAuthentication([
                'cookie' => $response->getHttpCookieList()->toArray()
            ]);
            return true;
        }

        return false;
    }

    public function getResponse(Contract $contract)
    {
        $contract->validate();

        if (empty($this->getAuthentication())) {
            if (!$this->authentication()) {
                throw new AuthenticationException('Authentication failed.');
            }
        }

        var_export($this->getAuthentication());
        die();

        $request = new Request();
        $request
            ->setMethod(Request::HTTP_METHOD_POST)
            ->setUrl(
                $this->getConfig()->getApiUrlScheme() . '://' .
                $this->getConfig()->getUserDomain() . '.' . $this->getConfig()->getApiDomain() .
                '/' . $this->getConfigurationNumber() . '/dataservice/' . $this->getDataFormat() .
                '/reply/' . $contract->getContractQuery()
            )
            ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
            ->setBody(json_encode($contract->toArray()))
            /*
            ->disableSSLValidation()
            ->addHeader(new Header(array(
                'name' => 'test3',
                'value' => 'Simple3'
            )))
            ->addCookie(new Cookie(array(
                'name' => 'cookieName2',
                'value' => 'cookieValue2',
            )))
            */
            ->setTimeOut($this->getConfig()->getApiConnectTimeOut());

        $response = $this->getHttpClient()->request($request);
    }
}
