<?php

namespace Tests;

use Konsulting\Payments\Pay360\Api;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function test_it_can_be_constructed()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);

        self::assertInstanceOf(Api::class, $api);
    }

    public function test_it_can_create_a_session()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);
        $api->setTesting(true);

        var_dump($api->hostedPayments()->createSession([
            'transaction' => [
                'merchantReference' => 'TEST-'.time(),
                'money' => [
                    'currency' => 'GBP',
                    'amount' => ['fixed' => 10.00]
                ],
            ],
            'session' => [
                'returnUrl' => ['url' => 'https://klever.co.uk'],
            ],
        ]));
    }

    public function test_it_can_retrieve_a_session()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);
        $api->setTesting(true);

        var_dump($api->hostedPayments()->retrieveSession('SMjpXUn_qoPRBL5HkjEOK-zEQ'));
    }

    public function test_it_can_retrieve_a_transaction()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);
        $api->setTesting(true);

        var_dump($api->transactions()->getTransactionById('10135282971'));
    }

    public function test_it_can_refund_a_transaction()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);
        $api->setTesting(true);

        var_dump($api->transactions()->refundTransaction('10135282971', 5));
    }

    public function test_it_can_get_reporting_metdata()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);
        $api->setTesting(true);

        var_dump($api->reporting()->getMetaData());
    }

    public function test_it_can_get_reporting_data()
    {
        $api = new Api($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['HOSTED_ID'], $_ENV['API_ID']);
        $api->setTesting(true);

        var_dump($api->reporting()->getReport(['limit' => 10]));
    }
}

// Returns with...
// ?sessionId=SMjpXUn_qoPRBL5HkjEOK-zEQ&paymentMethodsAcceptingTokens=CARD&optionalCardRegistration=false&isGuestPayment=true&shouldShowBackButton=false

// string(277) "{"status":"SUCCESS","hostedSessionStatus":{"sessionId":"SMjpXUn_qoPRBL5HkjEOK-zEQ","context":"https://secure.mite.pay360.com/hosted","stale":false,"lastInteraction":1620925319071,"sessionState":"TERMINATED","transactionState":{"id":"10135282971","transactionState":"SUCCESS"}}}"

// string(1917) "{"locale":"en","processing":{"model":"MANAGE","authResponse":{"statusCode":"00","acquirerName":"Barclays Merchant Services","message":"Approved - no action","authCode":"073483","gatewayReference":"111gbpe75b42c2bd59ecdAMeeee10z00","gatewayCode":"000.000.000","gatewayMessage":"Transaction succeeded","cv2Check":"MATCHED","status":"AUTHORISED"},"route":"PAYON"},"paymentMethod":{"registered":false,"card":{"cardFingerprint":"0hbdt0r/7ofTCqA5qKilqtHeeJg=","new":true,"cardType":"MC_DEBIT","cardUsageType":"DEBIT","cardScheme":"MASTERCARD","cardCategory":"DEBIT","maskedPan":"990000******0010","expiryDate":"0322","issuer":"PAY360 TESTING","issuerCountry":"GBR","cardHolderName":"Test Test","validDate":"0120"},"billingAddress":{"line1":"","line2":"","line3":"","line4":"","city":"","region":"","postcode":""},"paymentClass":"CARD","reuse":{"storage":"NONE"}},"threeDSecure":{"scheme":"MASTERCARD_SECURECODE","status":"NOT_ENROLLED","enrolmentIndicator":"N","enrolmentStatus":"NOT_ENROLLED","enrolmentDateTime":"2021-05-13T18:01:58.532+01:00","xid":"00000000010135282971","eci":"01","version":1,"protocolVersion":"1.0.2","versionsAttempted":[{"version":2,"availability":"INSUFFICIENT_DATA"},{"version":1,"availability":"ISSUER_NO_V1"}]},"customer":{"ip":"134.225.2.150","registered":false},"transaction":{"transactionId":"10135282971","merchantRef":"TEST-1620925169","status":"SUCCESS","stage":"COMPLETE","type":"PAYMENT","amount":10.00,"consumerSpend":10.00,"currency":"GBP","transactionTime":"2021-05-13T18:01:58.229+01:00","receivedTime":"2021-05-13T18:01:58.229+01:00","channel":"WEB","customerInitiated":true},"sessionId":"SMjpXUn_qoPRBL5HkjEOK-zEQ","history":[{"transactionStatus":"SUCCESS","reasonCode":"S100","reasonMessage":"Authorised","timeStamp":"2021-05-13T18:01:58.558+01:00"}],"followUpStatus":{},"link":[{"rel":"self","href":"https://api.mite.pay360.com/acceptor/rest/transactions/5307846/10135282971"}]}"

// "{"processing":{"model":"MANAGE","authResponse":{"statusCode":"00","acquirerName":"Barclays Merchant Services","message":"Approved - no action","authCode":"087657","gatewayReference":"141gbp5f470e9f6a97d31AMeeeee5z00","gatewayCode":"000.000.000","gatewayMessage":"Transaction succeeded","status":"AUTHORISED"},"route":"PAYON"},"customFields":{"fieldState":[]},"transaction":{"transactionId":"10135282998","status":"SUCCESS","stage":"COMPLETE","type":"REFUND","amount":5.00,"consumerSpend":5.00,"currency":"GBP","transactionTime":"2021-05-13T18:36:15.472+01:00","receivedTime":"2021-05-13T18:36:15.472+01:00","channel":"WEB","relatedTransaction":{"transactionId":"10135282971","merchantRef":"TEST-1620925169"}},"outcome":{"status":"SUCCESS","reasonCode":"S100","reasonMessage":"Authorised"},"trace":"TULHnFoPP-aYfufF6Uh7IkQ","link":[{"rel":"transaction","href":"https://api.mite.pay360.com/acceptor/rest/transactions/5307846/10135282998"},{"rel":"related-transaction","href":"https://api.mite.pay360.com/acceptor/rest/transactions/5307846/10135282971"}]}"