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
        return $this->api->getHttpClient()->postJson($this->getEndpoint('report'), $details);
    }

    public function getTransactionsInDateRange($from, $to, $page = 1, $perPage = 1000)
    {
        return $this->getReport([
            'limit' => $perPage,
            'startFrom' => ($page-1)*$perPage + 1,
            'fields' => [
                [
                    'field' => 'txn_id',
                    'display' => true,
                    'sort' => 'ASC',
                    'sortOrder' => 1,
                ],
                [
                    'field' => 'txn_date',
                    'display' => true,
                    'filter' => ['operation' => 'GTE', 'value' => [date('Y-m-d', strtotime($from))]]
                ],
                [
                    'field' => 'txn_date',
                    'display' => false,
                    'filter' => ['operation' => 'LTE', 'value' => [date('Y-m-d', strtotime($to))]]
                ],
                [
                    'field' => 'txn_type',
                    'display' => true,
                ],
                [
                    'field' => 'amount',
                    'display' => true,
                ],
                [
                    'field' => 'ccy_code',
                    'display' => true,
                ],
                [
                    'field' => 'txn_status',
                    'display' => true,
                ],
                [
                    'field' => 'merch_ref',
                    'display' => true,
                ],
            ],
            'includeFieldNames' => true,
        ]);
    }
}