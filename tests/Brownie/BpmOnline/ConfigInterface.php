<?php

namespace Test\Brownie\BpmOnline;

interface ConfigInterface
{

    public function getApiUrlScheme();

    public function getApiDomain();

    public function getApiConnectTimeOut();

    public function getUserDomain();

    public function getUserName();

    public function getUserPassword();
}
