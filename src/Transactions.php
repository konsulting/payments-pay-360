<?php

namespace Konsulting\Payments\Pay360;

use Konsulting\Payments\Pay360\Concerns\HasEndpoints;

class Transactions
{
    use HasEndpoints;

    protected $api;
    protected $instId;
    protected $endpoints = [
        'get_transaction_by_id' => '/acceptor/rest/transactions/{instId}/{transactionId}',
        'get_transactions_by_reference' => '/acceptor/rest/transactions/{instId}/byRef?merchantRef={merchantRef}',
        'refund_transaction' => '/acceptor/rest/transactions/{instId}/{transactionId}/refund',
    ];

    public function __construct(Api $api, $instId)
    {
        $this->api = $api;
        $this->instId = $instId;
    }

    public function checkTransactionStatus()
    {

    }

    public function refundTransaction($id, $amount = null, $reference = null)
    {
        $transaction = [];

        if ($reference) {
            $transaction['merchantRef'] = $reference;
        }

        if ($amount) {
            $transaction['currency'] = 'GBP';
            $transaction['amount'] = $amount;
        }

        return $this->api->getHttpClient()->postJson($this->getEndpoint('refund_transaction', ['transactionId' => $id]), compact('transaction'));
    }

    public function getTransactionById($id)
    {
        return $this->api->getHttpClient()->get($this->getEndpoint('get_transaction_by_id', ['transactionId' => $id]));
    }

    public function getTransactionsByReference($reference)
    {
        return $this->api->getHttpClient()->get($this->getEndpoint('get_transactions_by_reference', ['merchantRef' => $reference]));
    }
}