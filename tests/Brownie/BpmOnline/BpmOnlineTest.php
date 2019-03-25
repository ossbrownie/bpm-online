<?php

namespace Test\Brownie\BpmOnline;

use Brownie\BpmOnline\BpmOnline;
use Brownie\BpmOnline\Config;
use Brownie\BpmOnline\DataService\Contract\InsertContract;
use Brownie\HttpClient\Cookie\CookieInterface;
use Brownie\HttpClient\HttpClient;
use Brownie\HttpClient\ResponseInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Test\Brownie\BpmOnline\ConfigInterface;
use Test\Brownie\BpmOnline\DataService\ContractInterface;
use Brownie\HttpClient\Request;
use Brownie\HttpClient\Response;
use Brownie\HttpClient\Cookie\CookieList;
use Brownie\HttpClient\Cookie\Cookie;
use Brownie\HttpClient\Header\Header;
use Brownie\BpmOnline\DataService\Response\InsertContract as ResponseInsertContract;

class BpmOnlineTest extends TestCase
{

    /**
     * @var BpmOnline
     */
    private $bpmOnline;

    protected function setUp()
    {
        //$this->initHttpClient();
    }

    protected function tearDown()
    {
        $this->bpmOnline = null;
    }

    private function initHttpClient($httpCode, $responseBody)
    {
        $httpClient = $this->prophesize(HttpClient::class);

        $httpClientMethodCreateRequest = new MethodProphecy(
            $httpClient,
            'createRequest',
            []
        );

        $request = $this->createRequestMock();

        $httpClient
            ->addMethodProphecy(
                $httpClientMethodCreateRequest->willReturn($request)
            );

        $httpClientMethodRequest = new MethodProphecy(
            $httpClient,
            'request',
            [$request, Argument::any(), Argument::any()]
        );

        $httpClient
            ->addMethodProphecy(
                $httpClientMethodRequest->willReturn($this->createResponseMock(
                    $httpCode,
                    $responseBody
                ))
            );

        $httpClientMethodCreateHeader = new MethodProphecy(
            $httpClient,
            'createHeader',
            [Argument::any(), Argument::any()]
        );


        $header = $this->prophesize(Header::class);

        $httpClient
            ->addMethodProphecy(
                $httpClientMethodCreateHeader->willReturn($header->reveal())
            );

        $config = $this->createConfigMock();

        $this->bpmOnline = new BpmOnline(
            $httpClient->reveal(),
            $config
        );
    }


    private function createConfigMock()
    {
        $config = $this->prophesize(Config::class);

        $config->willImplement(ConfigInterface::class);

        $configMethodGetApiUrlScheme = new MethodProphecy(
            $config,
            'getApiUrlScheme',
            []
        );

        $configMethodGetUserDomain = new MethodProphecy(
            $config,
            'getUserDomain',
            []
        );

        $configMethodGetApiDomain = new MethodProphecy(
            $config,
            'getApiDomain',
            []
        );

        $configMethodGetUserName = new MethodProphecy(
            $config,
            'getUserName',
            []
        );

        $configMethodGetUserPassword = new MethodProphecy(
            $config,
            'getUserPassword',
            []
        );

        $configMethodGetApiConnectTimeOut = new MethodProphecy(
            $config,
            'getApiConnectTimeOut',
            []
        );

        $config
            ->addMethodProphecy(
                $configMethodGetApiUrlScheme->willReturn('https')
            );

        $config
            ->addMethodProphecy(
                $configMethodGetUserDomain->willReturn('testdomain')
            );

        $config
            ->addMethodProphecy(
                $configMethodGetApiDomain->willReturn('bpmonline.com')
            );

        $config
            ->addMethodProphecy(
                $configMethodGetUserName->willReturn('userLogin')
            );

        $config
            ->addMethodProphecy(
                $configMethodGetUserPassword->willReturn('userPassword')
            );

        $config
            ->addMethodProphecy(
                $configMethodGetApiConnectTimeOut->willReturn(60)
            );

        return $config->reveal();
    }

    private function createRequestMock()
    {
        $request = $this->prophesize(Request::class);

        $requestMethodSetMethod = new MethodProphecy(
            $request,
            'setMethod',
            [Request::HTTP_METHOD_POST]
        );

        $requestMethodSetUrl = new MethodProphecy(
            $request,
            'setUrl',
            ['https://testdomain.bpmonline.com/ServiceModel/AuthService.svc/Login']
        );

        $requestMethodSetUrl2 = new MethodProphecy(
            $request,
            'setUrl',
            ['https://testdomain.bpmonline.com/0/dataservice/json/reply/InsertContract']
        );

        $requestMethodSetBodyFormat = new MethodProphecy(
            $request,
            'setBodyFormat',
            [Request::FORMAT_APPLICATION_JSON]
        );

        $requestMethodAddHeader = new MethodProphecy(
            $request,
            'addHeader',
            [Argument::any()]
        );

        $requestMethodSetBody = new MethodProphecy(
            $request,
            'setBody',
            ['{"UserName":"userLogin","UserPassword":"userPassword"}']
        );

        $requestMethodSetBody2 = new MethodProphecy(
            $request,
            'setBody',
            ['{"test":"ok"}']
        );

        $requestMethodSetTimeOut = new MethodProphecy(
            $request,
            'setTimeOut',
            [60]
        );

        $requestMethodAddCookie = new MethodProphecy(
            $request,
            'addCookie',
            [Argument::any()]
        );

        $request
            ->addMethodProphecy(
                $requestMethodSetMethod->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodSetUrl->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodSetUrl2->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodSetBodyFormat->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodAddHeader->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodSetBody->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodSetBody2->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodSetTimeOut->willReturn($request)
            );

        $request
            ->addMethodProphecy(
                $requestMethodAddCookie->willReturn($request)
            );

        return $request->reveal();
    }

    private function createResponseMock($httpCode = 200, $body = '{"Code":"0"}')
    {
        $response = $this->prophesize(Response::class);

        $response->willImplement(ResponseInterface::class);

        $responseMethodGetHttpCode = new MethodProphecy(
            $response,
            'getHttpCode',
            []
        );

        $responseMethodGetBody = new MethodProphecy(
            $response,
            'getBody',
            []
        );

        $responseMethodGetHttpCookieList = new MethodProphecy(
            $response,
            'getHttpCookieList',
            []
        );

        $response
            ->addMethodProphecy(
                $responseMethodGetHttpCode->willReturn($httpCode)
            );

        $response
            ->addMethodProphecy(
                $responseMethodGetBody->willReturn($body)
            );

        $cookieList = $this->prophesize(CookieList::class);

        $cookieListMethodGetHttpCookieList1 = new MethodProphecy(
            $cookieList,
            'get',
            ['.aspxauth']
        );

        $cookieListMethodGetHttpCookieList2 = new MethodProphecy(
            $cookieList,
            'get',
            ['bpmcsrf']
        );

        $cookie = $this->prophesize(Cookie::class);

        $cookie->willImplement(CookieInterface::class);

        $cookieListMethodGetValue = new MethodProphecy(
            $cookie,
            'getValue',
            []
        );

        $cookie
            ->addMethodProphecy(
                $cookieListMethodGetValue->willReturn('testValue')
            );

        $cookieList
            ->addMethodProphecy(
                $cookieListMethodGetHttpCookieList1->willReturn($cookie->reveal())
            );

        $cookieList
            ->addMethodProphecy(
                $cookieListMethodGetHttpCookieList2->willReturn($cookie->reveal())
            );

        $response
            ->addMethodProphecy(
                $responseMethodGetHttpCookieList->willReturn($cookieList)
            );

        return $response->reveal();
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\HttpCodeException
     */
    public function testGetResponseHttpCodeException()
    {
        $this->initHttpClient(403, '{"Code":0}');
        $insertContract = $this->prophesize(InsertContract::class);
        $this->bpmOnline->getResponse($insertContract->reveal());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\AuthenticationException
     */
    public function testGetResponseAuthenticationException1()
    {
        $this->initHttpClient(200, '{"Code":1}');
        $insertContract = $this->prophesize(InsertContract::class);
        $this->bpmOnline->getResponse($insertContract->reveal());
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\AuthenticationException
     */
    public function testGetResponseAuthenticationException2()
    {
        $this->initHttpClient(200, '{"Code":"0}');
        $insertContract = $this->prophesize(InsertContract::class);
        $this->bpmOnline->getResponse($insertContract->reveal());
    }

    public function testGetResponse()
    {
        $this->initHttpClient(200, '{"Code":0}');

        $insertContract = $this->createInsertContract();

        $insertContractMethodGetResponse = new MethodProphecy(
            $insertContract,
            'getResponse',
            ['{"Code":0}']
        );

        $responseInsertContract = $this->prophesize(ResponseInsertContract::class);

        $responseInsertContract = $responseInsertContract->reveal();

        $insertContract
            ->addMethodProphecy(
                $insertContractMethodGetResponse->willReturn($responseInsertContract)
            );

        $contractResponse = $this->bpmOnline->getResponse($insertContract->reveal());

        $this->assertInstanceOf(ResponseInsertContract::class, $contractResponse);
        $this->assertEquals($responseInsertContract, $contractResponse);
    }

    private function createInsertContract()
    {
        $insertContract = $this->prophesize(InsertContract::class);

        $insertContract->willImplement(ContractInterface::class);

        $insertContractMethodGetContractType = new MethodProphecy(
            $insertContract,
            'getContractType',
            []
        );

        $insertContractMethodValidate = new MethodProphecy(
            $insertContract,
            'validate',
            []
        );

        $insertContractMethodToArray = new MethodProphecy(
            $insertContract,
            'toArray',
            []
        );

        $insertContract
            ->addMethodProphecy(
                $insertContractMethodGetContractType->willReturn('InsertContract')
            );

        $insertContract
            ->addMethodProphecy(
                $insertContractMethodValidate->willReturn(null)
            );

        $insertContract
            ->addMethodProphecy(
                $insertContractMethodToArray->willReturn(['test' => 'ok'])
            );

        return $insertContract;
    }

    /**
     * @expectedException \Brownie\BpmOnline\Exception\HttpCodeException
     */
    public function testGetResponseHttpCodeExceptionContract()
    {
        $this->initHttpClient(500, '{"Code":0}');

        $insertContract = $this->createInsertContract();

        $insertContractMethodGetResponse = new MethodProphecy(
            $insertContract,
            'getResponse',
            ['{"Code":0}']
        );

        $responseInsertContract = $this->prophesize(ResponseInsertContract::class);

        $responseInsertContract = $responseInsertContract->reveal();

        $insertContract
            ->addMethodProphecy(
                $insertContractMethodGetResponse->willReturn($responseInsertContract)
            );

        $cookie = $this->prophesize(Cookie::class);

        $cookie->willImplement(CookieInterface::class);

        $cookieListMethodGetValue = new MethodProphecy(
            $cookie,
            'getValue',
            []
        );

        $cookie
            ->addMethodProphecy(
                $cookieListMethodGetValue->willReturn('testValue')
            );

        $this->bpmOnline->setAuthentication([
            '.aspxauth' => $cookie->reveal(),
            'bpmcsrf' => $cookie->reveal(),
        ]);
        $this->bpmOnline->getResponse($insertContract->reveal());
    }
}
