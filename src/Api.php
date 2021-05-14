<?php

namespace Konsulting\Payments\Pay360;

use Konsulting\Payments\Pay360\Interfaces\HttpClient;

class Api
{
    protected $username;
    protected $password;
    protected $hostedId;
    protected $apiId;
    protected $isTesting = false;
    protected $httpClient;

    public function __construct($username, $password, $hostedId, $apiId, HttpClient $client = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->hostedId = $hostedId;
        $this->apiId = $apiId;

        $this->httpClient = null === $client ? new CurlClient() : $client;
        $this->httpClient->setSharedHeaders([
            'Accept: application/json',
            $this->getAuthBasicHeader(),
        ]);
    }

    public function getBaseUrl()
    {
        return $this->isTesting ? 'https://api.mite.pay360.com' : 'https://api.pay360.com';
    }

    public function getAuthBasicHeader()
    {
        return "Authorization: Basic ".base64_encode($this->username.':'.$this->password);
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function setTesting($bool = true)
    {
        $this->isTesting = $bool;

        return $this;
    }

    public function hostedPayments()
    {
        return new HostedPayments($this, $this->hostedId);
    }

    public function transactions()
    {
        return new Transactions($this, $this->apiId);
    }

    public function reporting()
    {
        return new Reporting($this, $this->apiId);
    }
}