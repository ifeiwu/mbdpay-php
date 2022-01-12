# 面包多支付

[面包多支付](https://mbd.pub/)（PHP SDK）是为个人而打造，安全，正规，低门槛的支付能力服务。

## 申请流程

##### [注册面包多](https://mianbaoduo.com/) -> [开通闪电结算](https://mianbaoduo.com/o/config/transaction/profile) -> [获取开发参数](https://mbd.pub/dev)

## 快速安装
```
composer require ifeiwu/mbdpay-php
```

## 开始使用

```php
require_once 'vendor/autoload.php';

$client = new Pagepan\MbdPayClient(MBDPAY_APP_ID, MBDPAY_APP_KEY);
```

### 获取用户 openid
###### 微信 JSAPI 支付必须
```php
// 完整的例子：example/wxjs.php

$openid = $_GET['openid'];

if ( ! $openid )
{
    $openid_url = $client->openid('http://192.168.31.2/mbdpay-php/example/wxjs.php');

    echo '<script>location.href="' . $openid_url. '";</script>';
}
else
{
    // ......
}
```

### 微信 JSAPI
###### 适用于微信内网页或扫码支付
```php
// 完整的例子：example/wxjs.php

$res = $client->wxjs($openid, 1, '产品说明', 'http://192.168.31.2/mbdpay-php/callback_url.php');
```

### 微信 H5
###### 适用于外部移动端浏览器或扫码支付
*支付使用前，请在控制台添加H5域名并确保审核通过*
```php
// 完整的例子：example/wxh5.php
 
$res = $client->wxh5(1, '产品说明');
```

### 支付宝
###### 适用于移动端网页或扫码支付
```php
// 完整的例子：example/alipay.php
  
echo $client->alipay('http://192.168.31.2/mbdpay-php/callback_url.php', 1, '产品说明', );
```

### 退款
```php
// 完整的例子：example/refund.php

$res = $client->refund('xxxxxxxxxxxxxxxxxxx');
```

### 订单查询
```php
// 完整的例子：example/order.php

$res = $client->order('xxxxxxxxxxxxxxxxxxx');
```