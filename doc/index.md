# SDK documentation

This page will document the API classes and ways to properly use the API.
Subsequent new releases also maintain backward compatibility with this class approach.
Welcome please submit the issue in Github directly.
[Bytom-PHP-SDK Issues](https://github.com/lxlxw/bytom-php-sdk/issues)

## API methods

* [`Key API`](#key-api)
* [`Account API`](#account-api)
* [`Asset API`](#asset-api)
* [`Transaction API`](#transaction-api)
* [`Wallet API`](#wallet-api)
* [`Access Token API`](#access-token-api)
* [`Block API`](#block-api)
* [`Mining API`](#mining-api)
* [`Other API`](#other-api)

## Key API


#### createKey

```php
BytomClient::createKey($alias, $password);
```

##### Parameters

- `String` - *alias*, name of the key.
- `String` - *password*, password of the key.

##### Returns

- `String` - *alias*, name of the key.
- `String` - *xpub*, pubkey of the key.
- `String` - *file*, path to the file of key.

----

#### listKeys

```php
BytomClient::listKeys();
```

##### Parameters

none

##### Returns

- `Array of Object`, keys owned by the client.
  - `Object`:
    - `String` - *alias*, name of the key.
    - `String` - *xpub*, pubkey of the key.

----

#### deleteKey

```php
BytomClient::deleteKey($xpub, $password);
```

##### Parameters

- `String` - *xpub*, pubkey of the key.
- `String` - *password*, password of the key.

##### Returns

none if the key is deleted successfully.

----

#### resetKeyPassword

```php
BytomClient::resetKeyPassword($xpub, $old_password, $new_password);
```

##### Parameters

`Object`:

- `String` - *xpub*, pubkey of the key.
- `String` - *old_password*, old password of the key.
- `String` - *new_password*, new password of the key.

##### Returns

none if the key password is reset successfully.


## Account API


#### createAccount
```php
BytomClient::createAccount($root_xpubs = [], $alias, $quorum = 1);
```

##### Parameters

- `Array of String` - *root_xpubs*, pubkey array.
- `String` - *alias*, name of the account.
- `Integer` - *quorum*, the default value is `1`, threshold of keys that must sign a transaction to spend asset units controlled by the account.

Optional:

- `String` - *access_token*, if optional when creating account locally. However, if you want to create account remotely, it's indispensable.

##### Returns

- `String` - *id*, account id.
- `String` - *alias*, name of account.
- `Integer` - *key_index*, key index of account.
- `Integer` - *quorom*, threshold of keys that must sign a transaction to spend asset units controlled by the account.
- `Array of Object` - *xpubs*, pubkey array.

----

#### listAccounts
```php
BytomClient::listAccounts();
```

##### Parameters

none

##### Returns

- `Array of Object`, account array.
  - `Object`:
    - `String` - *id*, account id.
    - `String` - *alias*, name of account.
    - `Integer` - *key_index*, key index of account.
    - `Integer` - *quorom*, threshold of keys that must sign a transaction to spend asset units controlled by the account.
    - `Array of Object` - *xpubs*, pubkey array.

----

#### deleteAccount
```php
BytomClient::deleteAccount($account_info);
```

##### Parameters

- `String` - *account_info*, alias or ID of account.

##### Returns

none if the account is deleted successfully.

----

#### createAccountReceiver
```php
BytomClient::createAccountReceiver($account_alias, $account_id);
```

##### Parameters

`Object`: account_alias | account_id

optional:

- `String` - *account_alias*, alias of account.
- `String` - *account_id*, id of account.

##### Returns

- `String` - *address*, address of account.
- `String` - *control_program*, control program of account.

----

#### listAddresses
```php
BytomClient::listAddresses($account_alias, $account_id);
```

##### Parameters

- `String` - *account_alias*, alias of account.
- `String` - *account_id*, id of account.

##### Returns

- `Array of Object`, account address array.
  - `Object`:
    - `String` - *account_alias*, alias of account.
    - `String` - *account_id*, id of account.
    - `String` - *address*, address of account.
    - `Boolean` - *change*, whether the account address is change.

----

#### validateAddress
```php
BytomClient::validateAddress($address);
```

##### Parameters

- `string` - *address*, address of account.

##### Returns

- `Boolean` - *vaild*, whether the account address is vaild.
- `Boolean` - *is_local*, whether the account address is local.


## Asset API


#### createAsset
```php
BytomClient::createAsset($root_xpubs = [], $alias, $quorum = 1);
```

##### Parameters

- `Array of String` - *root_xpubs*, pubkey array.
- `String` - *alias*, name of the asset.
- `Integer` - *quorum*, the default value is `1`, threshold of keys that must sign a transaction to spend asset units controlled by the account.

Optional:

- `Object` - *definition*, definition of asset.
- `String` - *access_token*, if optional when creating asset locally. However, if you want to create asset remotely, it's indispensable.

##### Returns

- `String` - *id*, asset id.
- `String` - *alias*, name of the asset.
- `String` - *issuance_program*, control program of the issuance of asset.
- `Array of Object` - *keys*, information of asset pubkey.
- `String` - *definition*, definition of asset.
- `Integer` - *quorum*, threshold of keys that must sign a transaction to spend asset units controlled by the account.

----

#### getAsset
```php
BytomClient::getAsset($asset_id);
```

##### Parameters

- `String` - *id*, id of asset.

##### Returns

- `String` - *id*, asset id.
- `String` - *alias*, name of the asset.
- `String` - *issuance_program*, control program of the issuance of asset.
- `Integer` - *key_index*, index of key for xpub.
- `Integer` - *quorum*, threshold of keys that must sign a transaction to spend asset units controlled by the account.
- `Array of Object` - *xpubs*, pubkey array.
- `String` - *type*, type of asset.
- `Integer` - *vm_version*, version of VM.
- `String` - *raw_definition_byte*, byte of asset definition.
- `Object` - *definition*, description of asset.

----

#### listAssets
```php
BytomClient::listAssets();
```

##### Parameters

none

##### Returns

- `Array of Object`, asset array.
  - `Object`:
    - `String` - *id*, asset id.
    - `String` - *alias*, name of the asset.
    - `String` - *issuance_program*, control program of the issuance of asset.
    - `Integer` - *key_index*, index of key for xpub.
    - `Integer` - *quorum*, threshold of keys that must sign a transaction to spend asset units controlled by the account.
    - `Array of Object` - *xpubs*, pubkey array.
    - `String` - *type*, type of asset.
    - `Integer` - *vm_version*, version of VM.
    - `String` - *raw_definition_byte*, byte of asset definition.
    - `Object` - *definition*, description of asset.

----

#### updateAssetAlias
```php
BytomClient::updateAssetAlias($asset_id, $alias);
```

##### Parameters

- `String` - *id*, id of asset.
- `String` - *alias*, new alias of asset.

##### Returns

none if the asset alias is updated success.

----

#### listBalances
```php
BytomClient::listBalances($asset_id, $alias);
```

##### Parameters

none

##### Returns

- `Array of Object`, balances owned by the account.
  - `Object`:
    - `String` - *account_id*, account id.
    - `String` - *account_alias*, name of account.
    - `String` - *asset_id*, asset id.
    - `String` - *asset_alias*, name of asset.
    - `Integer` - *amount*, specified asset balance of account.

----

#### listUnspentOutPuts
```php
BytomClient::listUnspentOutPuts($id);
```

##### Parameters

optional:

- `String` - *id*, id of unspent output.

##### Returns

- `Array of Object`, unspent output array.
  - `Object`:
    - `String` - *account_id*, account id.
    - `String` - *account_alias*, name of account.
    - `String` - *asset_id*, asset id.
    - `String` - *asset_alias*, name of asset.
    - `Integer` - *amount*, specified asset balance of account.
    - `String` - *address*, address of account.
    - `Boolean` - *change*, whether the account address is change.
    - `String` - *id*, unspent output id.
    - `String` - *program*, program of account.
    - `String` - *control_program_index*, index of program.
    - `String` - *source_id*, source unspent output id.
    - `String` - *source_pos*, position of source unspent output id in block.
    - `String` - *valid_height*, valid height.


## Transaction API


#### buildTransaction
```php
BytomClient::buildTransaction($actions = [], $base_transaction = null, $ttl = 0);
```

##### Parameters

- `String` - *base_transaction*, base data for the transaction.
- `Integer` - *ttl*, integer of the time to live in seconds.
- `Arrary of Object` - *actions*:
  - `Object`:
    - `String` - *account_id* | *account_alias*, alias or ID of account.
    - `String` - *asset_id* | *asset_alias*, alias or ID of asset.
    - `Integer` - *amount*, the specified asset of the amount sent with this transaction.
    - `String`- *type*, type of transaction, valid types: 'issue', 'spend', 'address'.
    - `String` - *address*, (type is address) address of receiver.
    - `String` - *receiver*, (type is spend) program of receiver.

##### Returns

- `Object of build-transaction` - *transaction*, builded transaction.

----

#### signTransaction
```php
BytomClient::signTransaction($password, $transaction);
```

##### Parameters

`Object`:

- `String` - *password*, signature of the password.
- `Object` - *transaction*, builded transaction.

##### Returns

`Object`:

- `Boolean` - *sign_complete*, returns true if sign succesfully and false otherwise.
- `Object of sign-transaction` - *transaction*, signed transaction.

----

#### submitTransaction
```php
BytomClient::submitTransaction($raw_transaction);
```

##### Parameters

- `Object` - *raw_transaction*, raw_transaction of signed transaction.

##### Returns

- `String` - *tx_id*, transaction id, hash of transaction.

----

#### estimateTransactionGas
```php
BytomClient::estimateTransactionGas($transaction_template);
```

##### Parameters

- `Object` - *transaction_template*, builded transaction response.

##### Returns

- `Integer` - *total_neu*, total consumed neu(1BTM = 10^8NEU) for execute transaction.
- `Integer` - *storage_neu*, consumed neu for storage transaction .
- `Integer` - *vm_neu*, consumed neu for execute VM.

----

#### getTransaction
```php
BytomClient::getTransaction($tx_id);
```

##### Parameters

`Object`:

- `String` - *tx_id*, transaction id, hash of transaction.

##### Returns

`Object`:

- `Integer` - *block_height*, block height where this transaction was in.
- `String` - *block_hash*, hash of the block where this transaction was in.
- `String` - *block_transactions_count*, transaction count where this transaction was in the block.
- `String` - *tx_id*, transaction id, hash of the transaction.
- `Integer` - *block_index*, position of the transaction in the block.
- `Boolean` - *status_fail*, whether the state of the request has failed.
- `String` - *block_time*, the unix timestamp for when the requst was responsed.
- `Array of Object` - *inputs*, object of inputs for the transaction.
- `Array of Object` - *outputs*, object of outputs for the transaction.

----

#### listTransactions
```php
BytomClient::listTransactions();
```

##### Parameters

`Object`:

optional:

- `String` - *tx_id*, transaction id, hash of transaction.
- `String` - *account_id*, id of account.
- `Bool`   - *detail* , flag of required transactions data ,default false (only return transaction summary)

##### Returns

`Array of Object`, transaction array.


## Wallet API


#### backupWallet
```php
BytomClient::backupWallet();
```

##### Parameters

none

##### Returns

- `Object` - *account_image*, account image.
- `Object` - *asset_image*, asset image.
- `Object` - *key_images*, key image.

----

#### restoreWallet
```php
BytomClient::restoreWallet();
```

##### Parameters

`Object`:

- `Object` - *account_image*, account image.
- `Object` - *asset_image*, asset image.
- `Object` - *key_images*, key image.

##### Returns

none if restore wallet success.


## Access Token API


#### createAccessToken
```php
BytomClient::createAccessToken($token_id);
```

##### Parameters

- `String` - *id*, token ID.

optional:

- `String` - *type*, type of token.

##### Returns

- `String` - *token*, access token.
- `String` - *id*, token ID.
- `String` - *type*, type of token.
- `Object` - *created_at*, time to create token.

----

#### listAccessTokens
```php
BytomClient::listAccessTokens();
```

##### Parameters

none

##### Returns

- `Array of Object`, access token array.
  - `Object`:
    - `String` - *token*, access token.
    - `String` - *id*, token ID.
    - `String` - *type*, type of token.
    - `Object` - *created_at*, time to create token.

----

#### deleteAccessToken
```php
BytomClient::deleteAccessToken($token_id);
```

##### Parameters

- `String` - *id*, token ID.

##### Returns

none if the access token is deleted successfully.

----

#### checkAccessToken
```php
BytomClient::checkAccessToken($token_id, $secret);
```

##### Parameters

- `String` - *id*, token ID.
- `String` - *secret*, secret of token, the second part of the colon division for token.

##### Returns

none if the access token is checked valid.


## Block API


#### getBlockCount
```php
BytomClient::getBlockCount();
```

##### Parameters

none

##### Returns

- `Integer` - *block_count*, recent block height of the blockchain.

----

#### getBlockHash
```php
BytomClient::getBlockHash();
```

##### Parameters

none

##### Returns

- `String` - *block_hash*, recent block hash of the blockchain.

----

#### getBlock
```php
BytomClient::getBlock($block_hash, $block_height);
```

##### Parameters

`Object`: block_height | block_hash

optional:

- `String` - *block_hash*, hash of block.
- `Integer`    - *block_height*, height of block.

##### Returns

`Object`:

----

#### getBlockHeader
```php
BytomClient::getBlockHeader($block_hash, $block_height);
```

##### Parameters

`Object`: block_height | block_hash

optional:

- `String` - *block_hash*, hash of block.
- `Integer`    - *block_height*, height of block.

##### Returns

- `Object` - *block_header*, header of block.
- `Integer` - *reward*, reward.

----

#### getDifficulty
```php
BytomClient::getDifficulty($block_hash, $block_height);
```

##### Parameters

`Object`:

optional:

- `String` - *block_hash*, hash of block.
- `Integer` - *block_height*, height of block.

##### Returns

`Object`:

- `Integer` - *bits*, bits of block.
- `String` - *difficulty*, difficulty of block.
- `String` - *hash*, block hash.
- `Integer` - *height*, block height.

----

#### getHashRate
```php
BytomClient::getHashRate($block_hash, $block_height);
```

##### Parameters

`Object`:

optional:

- `String` - *block_hash*, hash of block.
- `Integer` - *block_height*, height of block.

##### Returns

`Object`:

- `Integer` - *hash_rate*, difficulty of block.
- `String` - *hash*, block hash.
- `Integer` - *height*, block height.


## Mining API


#### isMining
```php
BytomClient::isMining();
```

##### Parameters

none

##### Returns

- `Boolean` - *is_mining*, whether the node is mining.

----

#### setMining
```php
BytomClient::setMining();
```

##### Parameters

- `Boolean` - *is_mining*, whether the node is mining.


## Other API


#### netInfo
```php
BytomClient::netInfo();
```

##### Parameters

none

##### Returns

- `Boolean` - *listening*, whether the node is listening.
- `Boolean` - *syncing*, whether the node is syncing.
- `Boolean` - *mining*, whether the node is mining.
- `Integer` - *peer_count*, current count of connected peers.
- `Integer` - *current_block*, current block height in the node's blockchain.
- `Integer` - *highest_block*, current highest block of the connected peers.
- `String` - *network_id*, network id.
- `String` - *version*, bytom version.

----

#### gasRate
```php
BytomClient::gasRate();
```

##### Parameters

none

##### Returns

- `Integer` - *gas_rate*, gas rate.

----

#### verifyMessage
```php
BytomClient::verifyMessage($address, $derived_xpub, $message, $signature);
```

##### Parameters

- `String` - *address*, address for account.
- `String` - *derived_xpub*, derived xpub.
- `String` - *message*, message for signature by derived_xpub.
- `String` - *signature*, signature for message.

##### Returns

- `Boolean` - *result*, verify result.

----

#### getWork
```php
BytomClient::getWork();
```

##### Parameters

none

##### Returns

- `Object` - *block_header*, raw block header.
- `Object` - *seed*, seed.

----

#### submitWork
```php
BytomClient::submitWork($block_header);
```

##### Parameters

- `Object` - *block_header*, raw block header.

##### Returns

true if success