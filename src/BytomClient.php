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
 * A client class of Bytom API.
 *
 * @package Bytom
 */
class BytomClient
{
    /**
     * Default endpoints.
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
     * Pseudo hsm list key
     *
     * @param string $alias, name of the key.
     * @param string $password, password of the key.
     * @return Response
     */
    public function createKey($alias, $password)
    {
        return $this->httpClient->post($this->url. '/create-key', ['alias' => $alias, 'password' => $password]);
    }

    /**
     * Pseudo hsm list key
     *
     * @return Response
     */
    public function listKeys()
    {
        return $this->httpClient->post($this->url. '/list-keys');
    }

    /**
     * Pseudo hsm delete key
     *
     * @param string $xpub, pubkey of the key.
     * @param string $password, password of the key.
     * @return Response
     */
    public function deleteKey($xpub, $password)
    {
        return $this->httpClient->post($this->url. '/delete-key', ['xpub' => $xpub, 'password' => $password]);
    }

    /**
     * Pseudo hsm reset key password
     *
     * @param string $xpub, pubkey of the key.
     * @param string $old_password, old password of the key.
     * @param string $new_password, new password of the key.
     * @return Response
     */
    public function resetKeyPassword($xpub, $old_password, $new_password)
    {
        return $this->httpClient->post($this->url. '/reset-key-password', ['xpub' => $xpub, 'old_password' => $old_password, 'new_password' => $new_password]);
    }

    /**
     * Create account
     *
     * @param array $root_xpubs, pubkey array.
     * @param string $alias, name of the account.
     * @param integer $quorum, the default value is 1, threshold of keys that must sign a transaction to spend asset units controlled by the account.
     * @return Response
     */
    public function createAccount($root_xpubs = [], $alias, $quorum = 1)
    {
        return $this->httpClient->post($this->url. '/create-account', ['root_xpubs' => $root_xpubs, 'alias' => $alias, 'quorum' => $quorum]);
    }

    /**
     * List account
     *
     * @return Response
     */
    public function listAccounts()
    {
        return $this->httpClient->post($this->url. '/list-accounts');
    }

    /**
     * Delete account
     *
     * @param string $account_info, alias or ID of account.
     * @return Response
     */
    public function deleteAccount($account_info)
    {
        return $this->httpClient->post($this->url. '/delete-account', ['account_info' => $account_info]);
    }

    /**
     * Create account receiver
     *
     * @param string $account_alias
     * @param string $account_id
     * @return Response
     */
    public function createAccountReceiver($account_alias = "", $account_id = "")
    {
        return $this->httpClient->post($this->url. '/create-account-receiver', ['account_alias' => $account_alias, 'account_id' => $account_id]);
    }

    /**
     * List addresses
     *
     * @param string $account_alias, alias of account.
     * @param string $account_id, id of account.
     * @return Response
     */
    public function listAddresses($account_alias = "", $account_id = "")
    {
        $data = [];
        if(!empty($account_alias) && !empty($account_id)){
            $data = ['account_alias' => $account_alias, 'account_id' => $account_id];
        }
        return $this->httpClient->post($this->url. '/list-addresses', $data);
    }

    /**
     * Validate address
     *
     * @param string $address, address of account.
     * @return Response
     */
    public function validateAddress($address)
    {
        return $this->httpClient->post($this->url. '/validate-address', ['address' => $address]);
    }

    /**
     * Create asset
     *
     * @param array $root_xpubs, pubkey array.
     * @param string $alias, name of the asset.
     * @param string $quorum, the default value is 1, threshold of keys that must sign a transaction to spend asset units controlled by the account.
     * @return Response
     */
    public function createAsset($root_xpubs = [], $alias, $quorum = 1)
    {
        return $this->httpClient->post($this->url. '/create-asset', ['root_xpubs' => $root_xpubs, 'alias' => $alias, 'quorum' => $quorum]);
    }

    /**
     * Get asset
     *
     * @param string $asset_id, id of asset.
     * @return Response
     */
    public function getAsset($asset_id)
    {
        return $this->httpClient->post($this->url. '/get-asset', ['id' => $asset_id]);
    }

    /**
     * List assets
     *
     * @return Response
     */
    public function listAssets()
    {
        return $this->httpClient->post($this->url. '/list-assets');
    }

    /**
     * Update asset alias
     *
     * @param string $asset_id, id of asset.
     * @param string $alias, new alias of asset.
     * @return Response
     */
    public function updateAssetAlias($asset_id, $alias)
    {
        return $this->httpClient->post($this->url. '/update-asset-alias', ['id' => $asset_id, 'alias' => $alias]);
    }

    /**
     * List balances
     *
     * @return Response
     */
    public function listBalances()
    {
        return $this->httpClient->post($this->url. '/list-balances');
    }

    /**
     * List unspent out puts
     *
     * @param string $id, id of unspent output.
     * @return Response
     */
    public function listUnspentOutPuts($id = "")
    {
        $data = [];
        if(!empty($id)) $data = ['id' => $id];
        return $this->httpClient->post($this->url. '/list-unspent-outputs', $data);
    }

    /**
     * Build transaction
     *
     * @param array $actions
     * @param string $base_transaction, base data for the transaction.
     * @param string $ttl, integer of the time to live in seconds.
     * @return Response
     */
    public function buildTransaction($actions = [], $base_transaction = null, $ttl = 0)
    {
        return $this->httpClient->post($this->url. '/build-transaction', ['actions' => $actions, 'base_transaction' => $base_transaction, 'ttl' => $ttl]);
    }

    /**
     * Sign transaction
     *
     * @param string $password, signature of the password.
     * @param string $transaction, builded transaction.
     * @return Response
     */
    public function signTransaction($password, $transaction)
    {
        return $this->httpClient->post($this->url. '/sign-transaction', ['password' => $password, 'transaction' => $transaction]);
    }

    /**
     * Submit transaction
     *
     * @param string $raw_transaction, raw_transaction of signed transaction.
     * @return Response
     */
    public function submitTransaction($raw_transaction)
    {
        return $this->httpClient->post($this->url. '/submit-transaction', ['raw_transaction' => $raw_transaction]);
    }

    /**
     * Estimate transaction gas
     *
     * @param string $transaction_template, builded transaction response.
     * @return Response
     */
    public function estimateTransactionGas($transaction_template)
    {
        return $this->httpClient->post($this->url. '/estimate-transaction-gas', ['transaction_template' => $transaction_template]);
    }

    /**
     * Get transaction
     *
     * @param string $tx_id, transaction id, hash of transaction.
     * @return Response
     */
    public function getTransaction($tx_id)
    {
        return $this->httpClient->post($this->url. '/get-transaction', ['tx_id' => $tx_id]);
    }

    /**
     * List transactions
     *
     * @param string $tx_id, transaction id, hash of transaction.
     * @param string $account_id, id of account.
     * @param bool $detail , flag of required transactions data ,default false (only return transaction summary)
     * @return Response
     */
    public function listTransactions($tx_id = "", $account_id = "", $detail = false)
    {
        $data = [];
        if(empty($tx_id)) $data = ['tx_id' => $tx_id, 'detail' => $detail];
        if(empty($account_id)) $data = ['account_id' => $account_id, 'detail' => $detail];
        return $this->httpClient->post($this->url. '/list-transactions', $data);
    }

    /**
     * Backup wallet
     *
     * @return Response
     */
    public function backupWallet()
    {
        return $this->httpClient->post($this->url. '/backup-wallet');
    }

    /**
     * Restore wallet
     *
     * @param array $account_image, account image.
     * @param array $asset_image, asset image.
     * @param array $key_images, key image.
     * @return Response
     */
    public function restoreWallet($account_image = [], $asset_image = [], $key_images = [])
    {
        return $this->httpClient->post($this->url. '/restore-wallet', ['account_image' => $account_image, 'asset_image' => $asset_image, 'key_images' => $key_images]);
    }

    /**
     * Sign message
     *
     * @param string $address, address for account.
     * @param string $message, message for signature by address xpub.
     * @param string $password, password of account.
     * @return Response
     */
    public function signMessage($address, $message, $password)
    {
        return $this->httpClient->post($this->url. '/sign-message', ['address' => $address, 'message' => $message, 'password' => $password]);
    }

    /**
     * Create access token
     *
     * @param string $token_id, token ID.
     * @return Response
     */
    public function createAccessToken($token_id)
    {
        return $this->httpClient->post($this->url. '/create-access-token', ['id' => $token_id]);
    }

    /**
     * List account tokens
     *
     * @return Response
     */
    public function listAccessTokens()
    {
        return $this->httpClient->post($this->url. '/list-access-tokens');
    }

    /**
     * Delete access token
     *
     * @param string $token_id, token ID.
     * @return Response
     */
    public function deleteAccessToken($token_id)
    {
        return $this->httpClient->post($this->url. '/delete-access-token', ['id' => $token_id]);
    }

    /**
     * Check access token
     *
     * @param string $token_id, token ID.
     * @param string $secret, secret of token, the second part of the colon division for token.
     * @return Response
     */
    public function checkAccessToken($token_id, $secret)
    {
        return $this->httpClient->post($this->url. '/check-access-token', ['id' => $token_id, 'secret' => $secret]);
    }

    /**
     * Create transaction feed
     *
     * @param string $alias, name of the transaction feed.
     * @param string $filter, filter of the transaction feed.
     * @return Response
     */
    public function createTransactionFeed($alias, $filter)
    {
        return $this->httpClient->post($this->url. '/create-transaction-feed', ['alias' => $alias, 'filter' => $filter]);
    }

    /**
     * Get transaction feed
     *
     * @param string $alias, name of the transaction feed.
     * @return Response
     */
    public function getTransactionFeed($alias)
    {
        return $this->httpClient->post($this->url. '/get-transaction-feed', ['alias' => $alias]);
    }

    /**
     * List transaction feeds
     *
     * @return Response
     */
    public function listTransactionFeeds()
    {
        return $this->httpClient->post($this->url. '/list-transaction-feeds');
    }

    /**
     * Delete transaction feed
     *
     * @param string $alias, name of the transaction feed.
     * @return Response
     */
    public function deleteTransactionFeed($alias)
    {
        return $this->httpClient->post($this->url. '/delete-transaction-feed', ['alias' => $alias]);
    }

    /**
     * Update transaction feed
     *
     * @param string $alias, name of the transaction feed.
     * @param string $filter, filter of the transaction feed.
     * @return Response
     */
    public function updateTransactionFeed($alias, $filter)
    {
        return $this->httpClient->post($this->url. '/update-transaction-feed', ['alias' => $alias, 'filter' => $filter]);
    }

    /**
     * Get unconfirmed transaction
     *
     * @param string $tx_id, transaction id, hash of transaction.
     * @return Response
     */
    public function getUnconfirmedTransaction($tx_id)
    {
        return $this->httpClient->post($this->url. '/get-unconfirmed-transaction', ['tx_id' => $tx_id]);
    }

    /**
     * List unconfirmed transactions
     *
     * @return Response
     */
    public function listUnconfirmedTransactions()
    {
        return $this->httpClient->post($this->url. '/list-unconfirmed-transactions');
    }

    /**
     * Decode raw transaction
     *
     * @param string $raw_transaction, hexstring of raw transaction.
     * @return Response
     */
    public function decodeRawTransaction($raw_transaction)
    {
        return $this->httpClient->post($this->url. '/decode-raw-transaction', ['raw_transaction' => $raw_transaction]);
    }

    /**
     * Get block count
     *
     * @return Response
     */
    public function getBlockCount()
    {
        return $this->httpClient->post($this->url. '/get-block-count');
    }

    /**
     * Get block hash
     *
     * @return Response
     */
    public function getBlockHash()
    {
        return $this->httpClient->post($this->url. '/get-block-hash');
    }

    /**
     * Get block
     *
     * @param string $block_hash
     * @param string $block_height
     * @return Response
     */
    public function getBlock($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-block', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    /**
     * Get block header
     *
     * @param string $block_hash
     * @param string $block_height
     * @return Response
     */
    public function getBlockHeader($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-block-header', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    /**
     * Get difficulty
     *
     * @param string $block_hash
     * @param string $block_height
     * @return Response
     */
    public function getDifficulty($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-difficulty', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    /**
     * Get hash rate
     *
     * @param string $block_hash
     * @param string $block_height
     * @return Response
     */
    public function getHashRate($block_hash = "", $block_height = "")
    {
        return $this->httpClient->post($this->url. '/get-hash-rate', ['block_hash' => $block_hash, 'block_height' => $block_height]);
    }

    /**
     * Net info
     *
     * @return Response
     */
    public function netInfo()
    {
        return $this->httpClient->post($this->url. '/net-info');
    }

    /**
     * Is mining
     *
     * @return Response
     */
    public function isMining()
    {
        return $this->httpClient->post($this->url. '/is-mining');
    }

    /**
     * Set mining
     *
     * @param boolean $is_mining, whether the node is mining.
     * @return Response
     */
    public function setMining($is_mining)
    {
        return $this->httpClient->post($this->url. '/set-mining', ['is_mining' => $is_mining]);
    }

    /**
     * Gas rate
     *
     * @return Response
     */
    public function gasRate()
    {
        return $this->httpClient->post($this->url. '/gas-rate');
    }

    /**
     * Verify message
     *
     * @param string $address, address for account.
     * @param string $derived_xpub, derived xpub.
     * @param string $message, message for signature by derived_xpub.
     * @param string $signature, signature for message.
     * @return Response
     */
    public function verifyMessage($address, $derived_xpub, $message, $signature)
    {
        return $this->httpClient->post($this->url. '/verify-message', ['address' => $address, 'derived_xpub' => $derived_xpub, 'message' => $message, 'signature' => $signature]);
    }

    /**
     * Get work
     *
     * @return Response
     */
    public function getWork()
    {
        return $this->httpClient->post($this->url. '/get-work');
    }

    /**
     * Submit work
     *
     * @param string $block_header, raw block header.
     * @return Response
     */
    public function submitWork($block_header)
    {
        return $this->httpClient->post($this->url. '/submit-work', ['block_header' => $block_header]);
    }

}
