<?php

namespace Konsulting\Payments\Pay360\Interfaces;

interface HttpClient
{
    public function setSharedHeaders($headers);
    public function get($url, $data = [], $headers = []);
    public function postJson($url, $data = [], $headers = []);
}