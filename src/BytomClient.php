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

use Bytom\CurlHttpClient\CurlHttpClient;
use Bytom\Response;


/**
 * A client class of LINE Messaging API.
 *
 * @package Bytom
 */
class BytomClient
{
    /**
     * Default JSON-RPC endpoints.
     *
     * @var string
     */
    const DEFAULT_BYTOMD_URI = 'http://127.0.0.1:9888';

    /**
     * Constant for version string to include with requests. Currently 1.0.1.
     *
     * @var string
     */
    const SDK_VERSION = '1.0.1';

    /** @var string */
    private $url;

    /** @var HttpClient */
    private $httpClient;

    /** @var string */
    private $authToken;

    /**
     * BytomClient constructor.
     *
     * @param HTTPClient $httpClient HTTP client instance to use API calling.
     * @param array $args Configurations.
     */
    public function __construct($url = self::DEFAULT_BYTOMD_URI, $authToken = "")
    {
        $this->authToken = $authToken;
        $this->httpClient = new CurlHttpClient($this->authToken);
        $this->url = $url;
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
        return $this->httpClient->post($this->url. '/create-key', ['alias' => $alias, 'password' => $password]);
    }

    public function listKeys()
    {
        return $this->httpClient->post($this->url. '/list-keys');
    }

    public function deleteKey($xpub, $password)
    {
        return $this->httpClient->post($this->url. '/delete-key', ['xpub' => $xpub, 'password' => $password]);
    }

    public function resetKeyPassword($xpub, $old_password, $new_password)
    {
        return $this->httpClient->post($this->url. '/reset-key-password', ['xpub' => $xpub, 'old_password' => $old_password, 'new_password' => $new_password]);
    }

    public function createAccount($root_xpubs = [], $alias, $quorum = 1)
    {
        return $this->httpClient->post($this->url. '/create-account', ['root_xpubs' => $root_xpubs, 'alias' => $alias, 'quorum' => $quorum]);
    }

    public function listAccounts()
    {
        return $this->httpClient->post($this->url. '/list-accounts');
    }

    public function deleteAccount($account_info)
    {
        return $this->httpClient->post($this->url. '/delete-account', ['account_info' => $account_info]);
    }

    public function createAccountReceiver($account_alias = "", $account_id = "")
    {
        return $this->httpClient->post($this->url. '/create-account-receiver', ['account_alias' => $account_alias, 'account_id' => $account_id]);
    }

    public function listAddresses($account_alias = "", $account_id = "")
    {
        $data = [];
        if(!empty($account_alias) && !empty($account_id)){
            $data = ['account_alias' => $account_alias, 'account_id' => $account_id];
        }
        return $this->httpClient->post($this->url. '/list-addresses', $data);
    }

    public function validateAddress($address)
    {
        return $this->httpClient->post($this->url. '/validate-address', ['address' => $address]);
    }

    public function createAsset($root_xpubs = [], $alias, $quorum = 1)
    {
        return $this->httpClient->post($this->url. '/create-asset', ['root_xpubs' => $root_xpubs, 'alias' => $alias, 'quorum' => $quorum]);
    }

    public function getAsset($asset_id)
    {
        return $this->httpClient->post($this->url. '/get-asset', ['id' => $asset_id]);
    }

    public function listAssets()
    {
        return $this->httpClient->post($this->url. '/list-assets');
    }

    public function updateAssetAlias($asset_id, $alias)
    {
        return $this->httpClient->post($this->url. '/update-asset-alias', ['id' => $asset_id, 'alias' => $alias]);
    }

    public function listBalances()
    {
        return $this->httpClient->post($this->url. '/list-balances');
    }

    public function listUnspentOutPuts($id = "")
    {
        $data = [];
        if(!empty($id)) $data = ['id' => $id];
        return $this->httpClient->post($this->url. '/list-unspent-outputs', $data);
    }

    public function buildTransaction($actions = [], $base_transaction = null, $ttl = 0)
    {
        return $this->httpClient->post($this->url. '/build-transaction', ['actions' => $actions, 'base_transaction' => $base_transaction, 'ttl' => $ttl]);
    }

    public function signTransaction($password, $transaction)
    {
        return $this->httpClient->post($this->url. '/sign-transaction', ['password' => $password, 'transaction' => $transaction]);
    }

    public function submitTransaction($raw_transaction)
    {
        return $this->httpClient->post($this->url. '/submit-transaction', ['raw_transaction' => $raw_transaction]);
    }

    public function estimateTransactionGas($transaction_template)
    {
        return $this->httpClient->post($this->url. '/estimate-transaction-gas', ['transaction_template' => $transaction_template]);
    }

    public function getTransaction($tx_id)
    {
        return $this->httpClient->post($this->url. '/get-transaction', ['tx_id' => $tx_id]);
    }

    public function listTransactions($tx_id = "", $account_id = "", $detail = false)
    {
        $data = [];
        if(empty($tx_id)) $data = ['tx_id' => $tx_id, 'detail' => $detail];
        if(empty($account_id)) $data = ['account_id' => $account_id, 'detail' => $detail];
        return $this->httpClient->post($this->url. '/list-transactions', $data);
    }

    public function backupWallet()
    {
        return $this->httpClient->post($this->url. '/backup-wallet');
    }

    public function restoreWallet($account_image = [], $asset_image = [], $key_images = [])
    {
        return $this->httpClient->post($this->url. '/restore-wallet', ['account_image' => $account_image, 'asset_image' => $asset_image, 'key_images' => $key_images]);
    }

    public function signMessage($address, $message, $password)
    {
        return $this->httpClient->post($this->url. '/sign-message', ['address' => $address, 'message' => $message, 'password' => $password]);
    }

    public function createAccessToken($token_id)
    {
        return $this->httpClient->post($this->url. '/create-access-token', ['id' => $token_id]);
    }

    public function listAccessTokens()
    {
        return $this->httpClient->post($this->url. '/list-access-tokens');
    }

    public function deleteAccessToken($token_id)
    {
        return $this->httpClient->post($this->url. '/delete-access-token', ['id' => $token_id]);
    }

    public function checkAccessToken($token_id, $secret)
    {
        return $this->httpClient->post($this->url. '/check-access-token', ['id' => $token_id, 'secret' => $secret]);
    }

    public function createTransactionFeed($alias, $filter)
    {
        return $this->httpClient->post($this->url. '/create-transaction-feed', ['alias' => $alias, 'filter' => $filter]);
    }

    public function getTransactionFeed($alias)
    {
        return $this->httpClient->post($this->url. '/get-transaction-feed', ['alias' => $alias]);
    }

    public function listTransactionFeeds()
    {
        return $this->httpClient->post($this->url. '/list-transaction-feeds');
    }

    public function deleteTransactionFeed($alias)
    {
        return $this->httpClient->post($this->url. '/delete-transaction-feed', ['alias' => $alias]);
    }

    public function updateTransactionFeed($alias, $filter)
    {
        return $this->httpClient->post($this->url. '/update-transaction-feed', ['alias' => $alias, 'filter' => $filter]);
    }

    public function getUnconfirmedTransaction($tx_id)
    {
        return $this->httpClient->post($this->url. '/get-unconfirmed-transaction', ['tx_id' => $tx_id]);
    }

    public function listUnconfirmedTransactions()
    {
        return $this->httpClient->post($this->url. '/list-unconfirmed-transactions');
    }

    public function decodeRawTransaction($raw_transaction)
    {
        return $this->httpClient->post($this->url. '/decode-raw-transaction', ['raw_transaction' => $raw_transaction]);
    }

    public function getBlockCount()
    {
        return $this->httpClient->post($this->url. '/get-block-count');
    }

    public function getBlockHash()
    {
        return $this->httpClient->post($this->url. '/get-block-hash');
    }

    public function getBlock($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-block', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    public function getBlockHeader($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-block-header', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    public function getDifficulty($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-difficulty', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    public function getHashRate($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-hash-rate', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    public function netInfo()
    {
        return $this->httpClient->post($this->url. '/net-info');
    }

    public function isMining()
    {
        return $this->httpClient->post($this->url. '/is-mining');
    }

    public function setMining($is_mining)
    {
        return $this->httpClient->post($this->url. '/set-mining', ['is_mining' => $is_mining]);
    }

    public function gasRate()
    {
        return $this->httpClient->post($this->url. '/gas-rate');
    }

    public function verifyMessage($address, $derived_xpub, $message, $signature)
    {
        return $this->httpClient->post($this->url. '/verify-message', ['address' => $address, 'derived_xpub' => $derived_xpub, 'message' => $message, 'signature' => $signature]);
    }

    public function getWork()
    {
        return $this->httpClient->post($this->url. '/get-work');
    }

    public function submitWork($block_header)
    {
        return $this->httpClient->post($this->url. '/submit-work', ['block_header' => $block_header]);
    }

}
