## 安装

注意：Bytom SDK 需要PHP 5.4及以上版本。

### 使用Composer安装

你需要在你项目中使用Composer，如果你在项目中未使用[Composer](http://getcomposer.org/)，那么需要通过如下方式简单安装：

```bash
curl -sS https://getcomposer.org/installer | php
```

在你的项目根目录创建一个composer.json文件，包含下列内容：

```json
{
    "require": {
        "lxlxw/bytom-php-sdk" : "dev-master"
    }
}
```

安装完成后，运行“composer install”下载SDK并设置自动加载：

```php
require 'vendor/autoload.php';
```

### 使用Git安装

从github上clone该项目：https://github.com/lxlxw/bytom-php-sdk.git
```bash
git clone https://github.com/lxlxw/bytom-php-sdk.git
```

包含```autoload.php``` 文件从而自动获取Bytom SDK中的类

```php
require 'autoload.php';
```

## 开始使用

### 使用示例

你必须在你的应用中使用Composer autoloader来自动加载你的依赖，所有例子都默认你已经包含下列内容：

```php
require 'vendor/autoload.php';
use Bytom\BytomClient;
```

下面是一个如何使用SDK来发送消息的例子：

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

### 其他示例

请参考文档：[/doc](doc/index.md)

## 支持和反馈

如果你发现了该SDK的bug，请直接在github上提交issue：
[Bytom-PHP-SDK Issues](https://github.com/lxlxw/bytom-php-sdk/issues)

## 联系

- 邮箱：<x@xwlin.com>
