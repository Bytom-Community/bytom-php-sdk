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

namespace Bytom;

use Bytom\HttpClient;
use Bytom\Response;


/**
 * A client class of LINE Messaging API.
 *
 * @package Bytom
 */
class BytomClient
{
    const DEFAULT_BYTOMD_URI = '127.0.0.1:9988';

    /**
     * Constant for version string to include with requests. Currently 1.0.1.
     *
     * @var string
     */
    const SDK_VERSION = '1.0.1';

    /** @var string */
    private $channelSecret;
    /** @var string */
    private $bytomUri;
    /** @var HttpClient */
    private $httpClient;

    /**
     * BytomClient constructor.
     *
     * @param HTTPClient $httpClient HTTP client instance to use API calling.
     * @param array $args Configurations.
     */
    public function __construct(HttpClient $httpClient, array $args)
    {
        $this->httpClient = $httpClient;
        $this->channelSecret = $args['channelSecret'];

        $this->bytomUri = self::DEFAULT_BYTOMD_URI;
        if (array_key_exists('bytomUri', $args) && !empty($args['bytomUri'])) {
            $this->bytomUri = $args['endpointBase'];
        }
    }

    /**
     * Replies arbitrary message to destination which is associated with reply token.
     *
     * @param string $alias, name of the key.
     * @param string $password, password of the key.
     * @return Response
     */
    public function createKey($alias, $password)
    {
        return $this->httpClient->post($this->bytomUri. '/create-key', ['alias' => $alias, 'password' => $password]);
    }


}