<?php

namespace Konsulting\Payments\Pay360;

use Konsulting\Payments\Pay360\Concerns\HasEndpoints;

class Reporting
{
    use HasEndpoints;

    protected $api;
    protected $instId;
    protected $endpoints = [
        'metadata' => '/reporting/transactions/metadata',
        'report' => '/reporting/transactions/search'
    ];

    public function __construct(Api $api, $instId)
    {
        $this->api = $api;
        $this->instId = $instId;
    }

    public function getMetaData()
    {
        return $this->api->getHttpClient()->get($this->getEndpoint('metadata'));
    }

    /** https://docs.pay360.com/common-features/reporting-api/ */
    public function getReport($details = [])
    {
        return $this->api->getHttpClient()->get($this->getEndpoint('report'));
    }
}