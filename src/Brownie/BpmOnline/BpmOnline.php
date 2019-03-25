<?php
/**
 * @category    Brownie/BpmOnline
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     https://opensource.org/licenses/MIT
 */

namespace Brownie\BpmOnline;

use Brownie\BpmOnline\Exception\AuthenticationException;
use Brownie\BpmOnline\Exception\HttpCodeException;
use Brownie\HttpClient\Header\Header;
use Brownie\HttpClient\HTTPClient;
use Brownie\BpmOnline\DataService\Contract;
use Brownie\HttpClient\Request;
use Brownie\Util\StorageArray;
use Brownie\HttpClient\Exception\ClientException;
use Brownie\HttpClient\Exception\ValidateException;
use Brownie\BpmOnline\DataService\Response;

/**
 * API access to a single marketing management platform 'CRM-system bpm’online'
 *
 * @method HTTPClient   getHttpClient()             HTTP client.
 * @method Config       getConfig()                 Bpm'online config.
 * @method array        getAuthentication()         Returns authentication data.
 * @method BpmOnline    setAuthentication($data)    Sets authentication data.
 * @method int          getConfigurationNumber()    Returns configuration number.
 * @method string       getDataFormat()             Returns data format.
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

    /**
     * Sets the input values.
     *
     * @param HTTPClient    $httpClient     HTTP client.
     * @param Config        $config         Bpm'online config.
     */
    public function __construct(HTTPClient $httpClient, Config $config)
    {
        parent::__construct([
            'httpClient' => $httpClient,
            'config' => $config,
        ]);
    }

    /**
     * Creates a request to DataService.
     *
     * @param string    $url        Request URL.
     * @param string    $rawBody    Raw body.
     *
     * @return Request
     */
    private function createRequest($url, $rawBody)
    {
        return $this
            ->getHttpClient()
            ->createRequest()
            ->setMethod(Request::HTTP_METHOD_POST)
            ->setUrl($url)
            ->setBodyFormat(Request::FORMAT_APPLICATION_JSON)
            ->addHeader(new Header([
                'name' => 'Content-Type',
                'value' => Request::FORMAT_APPLICATION_JSON,
            ]))
            ->setBody($rawBody)
            ->setTimeOut($this->getConfig()->getApiConnectTimeOut());
    }

    /**
     * Authenticates in the DataService bpm'online.
     *
     * @throws AuthenticationException
     * @throws HttpCodeException
     * @throws ClientException
     * @throws ValidateException
     */
    private function authentication()
    {
        $request = $this
            ->createRequest(
                $this->getConfig()->getApiUrlScheme() . '://' .
                $this->getConfig()->getUserDomain() . '.' .
                $this->getConfig()->getApiDomain() .
                '/ServiceModel/AuthService.svc/Login',
                json_encode([
                    'UserName' => $this->getConfig()->getUserName(),
                    'UserPassword' => $this->getConfig()->getUserPassword(),
                ])
            );

        $response = $this->getHttpClient()->request($request);

        if (200 != $response->getHttpCode()) {
            throw new HttpCodeException('Invalid response code: ' . $response->getHttpCode());
        }

        $jsonResponse = json_decode($response->getBody(), true);

        if ((JSON_ERROR_NONE != json_last_error()) || (0 != $jsonResponse['Code']))
        {
            throw new AuthenticationException('Authentication failed.');
        }

        $this->setAuthentication([
            '.aspxauth' => $response->getHttpCookieList()->get('.aspxauth'),
            'bpmcsrf' => $response->getHttpCookieList()->get('bpmcsrf'),
        ]);
    }

    /**
     * Returns the response from the execution of the contract.
     *
     * @param Contract  $contract    DataService contract.
     * @param int       $attempts    Number of request retries.
     *
     * @return Response
     *
     * @throws AuthenticationException
     * @throws ClientException
     * @throws Exception\ValidateException
     * @throws HttpCodeException
     * @throws ValidateException
     */
    public function getResponse(Contract $contract, $attempts = 3)
    {
        $contract->validate();
        if (empty($this->getAuthentication())) {
            $this->authentication();
        }

        $request = $this
            ->createRequest(
                $this->getConfig()->getApiUrlScheme() . '://' .
                $this->getConfig()->getUserDomain() . '.' . $this->getConfig()->getApiDomain() .
                '/' . $this->getConfigurationNumber() . '/dataservice/' . $this->getDataFormat() .
                '/reply/' . $contract->getContractType(),
                json_encode($contract->toArray())
            )
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
            );

        $response = $this->getHttpClient()->request($request, $attempts, [200, 500]);
        $contractResponse = $contract->getResponse($response->getBody());

        if (200 != $response->getHttpCode()) {
            throw new HttpCodeException(
                'Invalid response code: ' . $response->getHttpCode() . ', ' .
                $contractResponse->getErrorMessage()
            );
        }

        return $contractResponse;
    }
}
