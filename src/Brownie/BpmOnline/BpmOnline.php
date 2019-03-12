<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline;

use Brownie\BpmOnline\Exception\AuthenticationException;
use Brownie\HttpClient\Header\Header;
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
 * @method BpmOnline    setAuthentication(array $authenticationData)
 * @method array        getAuthentication()
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
        $request = $this
            ->getHttpClient()
            ->createRequest()
            ->setMethod(Request::HTTP_METHOD_POST)
            ->setUrl(
                $this->getConfig()->getApiUrlScheme() . '://' .
                $this->getConfig()->getUserDomain() . '.' .
                $this->getConfig()->getApiDomain() .
                '/ServiceModel/AuthService.svc/Login'
            )
            ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
            ->addHeader(new Header([
                'name' => 'Content-Type',
                'value' => Request::FORMAT_APPLICATION_JSON,
            ]))
            ->setBody(json_encode([
                'UserName' => $this->getConfig()->getUserName(),
                'UserPassword' => $this->getConfig()->getUserPassword(),
            ]))
            ->setTimeOut($this->getConfig()->getApiConnectTimeOut());

        $response = $this->getHttpClient()->request($request);

        if (200 != $response->getHttpCode()) {
            return false;
        }

        $jsonResponse = json_decode($response->getBody(), true);

        if ((JSON_ERROR_NONE != json_last_error()) || (0 != $jsonResponse['Code']))
        {
            return false;
        }

        $this->setAuthentication([
            '.aspxauth' => $response->getHttpCookieList()->get('.aspxauth'),
            'bpmcsrf' => $response->getHttpCookieList()->get('bpmcsrf'),
        ]);

        return true;
    }

    public function getResponse(Contract $contract)
    {
        $contract->validate();

        if (empty($this->getAuthentication())) {
            if (!$this->authentication()) {
                throw new AuthenticationException('Authentication failed.');
            }
        }

        $request =
            $this
                ->getHttpClient()
                ->createRequest()
                ->setMethod(Request::HTTP_METHOD_POST)
                ->setUrl(
                    $this->getConfig()->getApiUrlScheme() . '://' .
                    $this->getConfig()->getUserDomain() . '.' . $this->getConfig()->getApiDomain() .
                    '/' . $this->getConfigurationNumber() . '/dataservice/' . $this->getDataFormat() .
                    '/reply/' . $contract->getContractType()
                )
                ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
                ->addHeader(new Header([
                    'name' => 'Content-Type',
                    'value' => Request::FORMAT_APPLICATION_JSON,
                ]))
                ->setBody(json_encode($contract->toArray()))
                ->addCookie($this->getAuthentication()['.aspxauth'])
                ->addCookie($this->getAuthentication()['bpmcsrf'])
                ->addHeader(
                    $this
                        ->getHttpClient()
                        ->createHeader('Authorization', 'Cookie')
                )
                ->addHeader(
                    $this
                        ->getHttpClient()
                        ->createHeader('BPMCSRF', $this->getAuthentication()['bpmcsrf']->getValue())
                )
                ->setTimeOut($this->getConfig()->getApiConnectTimeOut());

        $response = $this->getHttpClient()->request($request);

        return $response->getBody();
    }
}
