# Bytom PHP SDK

This SDK contains methods for easily interacting with the Bytom API.
Below are examples to get you started. For more information, please see Bytom API reference
documentation at https://github.com/Bytom/bytom/wiki

[![Latest Version](https://img.shields.io/badge/releases-v1.0.1-brightgreen.svg)](https://github.com/lxlxw/bytom-php-sdk/releases)
[![Total Downloads](https://img.shields.io/badge/packagist-v1.0.1-orange.svg)](https://packagist.org/packages/lxlxw/bytom-php-sdk)

## Table of Contents
- [Installation](#installation)
    - [Install with Composer](#install-with-composer)
    - [Install with Git](#install-with-git)
    - [Install with another method](#install-with-another-method)
- [Usage](#usage)
    - [Usage examples](#usage-examples)
    - [All usage examples](#all-usage-examples)
- [Support and Feedback](#support-and-feedback)
- [Contact](#contact)
- [License](#license)

## Installation

There are various ways to install and use this sdk. We'll elaborate on a couple here. Note that the Bytom PHP SDK requires PHP 5.4 or newer.

### Install with Composer

To install the SDK with Composer, you will need to be using [Composer](http://getcomposer.org/)
in your project.
If you aren't using Composer yet, it's really simple! Here's how to install
composer:

```bash
curl -sS https://getcomposer.org/installer | php
```

Then create a composer.json file in your projects root folder, containing:

```json
{
    "require": {
        "lxlxw/bytom-php-sdk" : "dev-master"
    }
}
```

Run "composer install" to download the SDK and set up the autoloader,
and then require it from your PHP script:

```php
require 'vendor/autoload.php';
```

### Install with Git

You can clone down this sdk using your favorite github client, or via the terminal.
```bash
git clone https://github.com/lxlxw/bytom-php-sdk.git
```

You can then include the ```autoload.php``` file in your code to automatically load the Bytom SDK classes.

```php
require 'autoload.php';
```

### Install with another method

If you downloaded this sdk using any other means you can treat it like you used the git method above.
Once it's installed you need only require the `autoload.php` to have access to the sdk.


## Usage

### Usage examples

You should always use Composer's autoloader in your application to automatically load the your dependencies. All examples below assumes you've already included this in your file:

```php
require 'vendor/autoload.php';
use Bytom\BytomClient;
```

Here's how to send a message using the SDK:

```php
# First, instantiate the SDK Client

# Local node, default url is `127.0.0.1:9888`
$client = new BytomClient();
# Remote node
$client = new BytomClient('url', 'auth-token');

# Now, request bytom api.
$alias = 'test_name';
$pwd = '123456';
$res = $client->createKey($alias, $pwd);
$data = $res->getJSONDecodedBody();
```

### All usage examples

You find more detailed documentation at [/doc](doc/index.md).

## Support and Feedback

If you find a bug, please submit the issue in Github directly.
[Bytom-PHP-SDK Issues](https://github.com/lxlxw/bytom-php-sdk/issues)

## Contact

- Mail：[x@xwlin.com](x@xwlin.com)

## License

Bytom PHP SDK is based on the MIT protocol.

<http://www.opensource.org/licenses/MIT>