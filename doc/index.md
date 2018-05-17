# SDK documentation

This page will document the API classes and ways to properly use the API.
Subsequent new releases also maintain backward compatibility with this class approach.
Welcome please submit the issue in Github directly.
[Bytom-PHP-SDK Issues](https://github.com/lxlxw/bytom-php-sdk/issues)

## API methods

* [`key-api`](#key-api)
* [`account-api`](#account-api)
* [`asset-api`](#asset-api)
* [`transaction-api`](#transaction-api)
* [`wallet-api`](#wallet-api)
* [`access-token-api`](#access-token-api)
* [`block-api`](#block-api)
* [`mining-api`](#mining-api)
* [`other-api`](#other-api)

## Key API

----

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
BytomClient::resetKeyPassword($xpub, $old_password, $new_password)
```

##### Parameters

`Object`:

- `String` - *xpub*, pubkey of the key.
- `String` - *old_password*, old password of the key.
- `String` - *new_password*, new password of the key.

##### Returns

none if the key password is reset successfully.


## Account API

----

#### createAccount
```php
BytomClient::createAccount($root_xpubs = [], $alias, $quorum = 1)
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
