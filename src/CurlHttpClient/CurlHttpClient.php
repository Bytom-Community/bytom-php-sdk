<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Bytom\CurlHttpClient;

use Bytom\Exception\CurlExecutionException;
use Bytom\HttpClient;
use Bytom\BytomClient;
use Bytom\Response;

/**
 * Class CurlHTTPClient.
 *
 * A HTTPClient that uses cURL.
 *
 * @package Bytom/HTTPClient
 */
class CurlHttpClient implements HttpClient
{
    /** @var array */
    private $authHeaders = [];

    /** @var array */
    private $userAgentHeader;

    /**
     * CurlHTTPClient constructor.
     *
     * @param string $channelToken Access token of your channel.
     */
    public function __construct($authToken)
    {
        $this->authHeaders = $authToken;

        $this->userAgentHeader = [
            'User-Agent: Bytom-PHP-SDK/' . BytomClient::SDK_VERSION,
        ];
    }

    /**
     * Sends GET request to Bytomd API.
     *
     * @param string $url Request URL.
     * @return Response Response of API request.
     */
    public function get($url)
    {
        return $this->sendRequest('GET', $url, [], []);
    }

    /**
     * Sends POST request to Bytomd API.
     *
     * @param string $url Request URL.
     * @param array $data Request body.
     * @return Response Response of API request.
     */
    public function post($url, $data = [])
    {
        return $this->sendRequest('POST', $url, ['Content-Type: application/json; charset=utf-8'], $data);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $additionalHeader
     * @param array $reqBody
     * @return Response
     * @throws CurlExecutionException
     */
    private function sendRequest($method, $url, $additionalHeader = [], $reqBody = [])
    {
        $curl = new Curl($url);

        $headers = array_merge($this->userAgentHeader, $additionalHeader);

        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_HEADER => true,
        ];
        if(!empty($this->authHeaders)){
            $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
            $options[CURLOPT_USERPWD] = $this->authHeaders;
        }

        if ($method === 'POST') {
            if (empty($reqBody)) {
                $options[CURLOPT_HTTPHEADER][] = 'Content-Length: 0';
            }
            $options[CURLOPT_POSTFIELDS] = json_encode($reqBody);
        }

        $curl->setoptArray($options);

        $result = $curl->exec();

        if ($curl->errno()) {
            throw new CurlExecutionException($curl->error());
        }

        $info = $curl->getinfo();

        $httpStatus = $info['http_code'];

        $responseHeaderSize = $info['header_size'];

        $responseHeaderStr = substr($result, 0, $responseHeaderSize);
        $responseHeaders = [];
        foreach (explode("\r\n", $responseHeaderStr) as $responseHeader) {
            $kv = explode(':', $responseHeader, 2);
            if (count($kv) === 2) {
                $responseHeaders[$kv[0]] = trim($kv[1]);
            }
        }

        $body = substr($result, $responseHeaderSize);

        return new Response($httpStatus, $body, $responseHeaders);
    }
}
