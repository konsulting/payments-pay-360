<?php

namespace Konsulting\Payments\Pay360;

use Konsulting\Payments\Pay360\Concerns\HasEndpoints;

class HostedPayments
{
    use HasEndpoints;

    protected $api;
    protected $instId;
    protected $endpoints = [
        'create_session' => '/hosted/rest/sessions/{instId}/payments',
        'retrieve_session' => '/hosted/rest/sessions/{instId}/{sessionId}/status',
    ];

    public function __construct(Api $api, $instId)
    {
        $this->api = $api;
        $this->instId = $instId;
    }

    public function createSession($data = [])
    {
        return $this->api->getHttpClient()->postJson($this->getEndpoint('create_session'), $data);
    }

    public function retrieveSession($sessionId)
    {
        return $this->api->getHttpClient()->get($this->getEndpoint('retrieve_session', ['sessionId' => $sessionId]));
    }

    public function handlePaymentResponse() // ????
    {

        // We can have different urls for the different outcomes...

        // There is the transaction notification Url, basically callback when it completes
        // The details passed back are here:
        // https://docs.pay360.com/common-features/notifications/

        // Can also do pre and post auth callbacks but don't think we need those.

        // returnUrl
        // cancelUrl

        // Need to look at skins

        // When response comes back the GET vars have 'sessionId' which we can validate against it in our session.
        // Then we can retrieve the transaction details from the session if we want to.

        // suggest completion is actually done through the callback page?
    }
}