# 面包多支付

目前还在开发阶段...

## 安装
```
composer require ifeiwu/mbdpay-php
```

## 使用

```php
require_once 'vendor/autoload.php';

$client = new Pagepan\MbdPayClient(MBDPAY_APP_ID, MBDPAY_APP_KEY);
```

### 微信 JS 网页支付
```php
// 完整的例子：example/wxjs.php

$openid = $_GET['openid'];

if ( ! $openid )
{
    $openid_url = $client->openid('http://192.168.31.2/mbdpay-php/example/wxjs.php');

    echo '<p>正在打开微信支付窗口...</p><script>location.href="' . $openid_url. '";</script>';
}
else
{
    $res = $client->wxjs($openid, 1, '产品说明', 'http://192.168.31.2/mbdpay-php/callback_url.php');
    
    // ......
}
```

### 支付宝 网页支付
```php
// 完整的例子：example/alipay.php

$client = new Pagepan\MbdPayClient(MBDPAY_APP_ID, MBDPAY_APP_KEY);
        
echo $client->alipay('http://192.168.31.2/mbdpay-php/callback_url.php', 1, '产品说明', );
```