<?php


namespace Konsulting\Payments\Pay360;


use Konsulting\Payments\Pay360\Interfaces\HttpClient;

class CurlClient implements HttpClient
{
    protected $sharedHeaders = [];

    public function setSharedHeaders($headers)
    {
        $this->sharedHeaders = $headers;
    }

    public function get($url, $data = [], $headers = [])
    {
        if (! empty($data)) {
            $params = http_build_query($data);
            $url .= (strpos($url, '?') !== false ? '&' : '?').$params;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->sharedHeaders, $headers));

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    public function postJson($url, $data = [], $headers = [])
    {
        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->sharedHeaders, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ], $headers));

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}