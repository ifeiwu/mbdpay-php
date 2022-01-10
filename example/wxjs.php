<html>
    <head>
        <title>微信 JSAPI 支付</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta name="format-detection" content="email=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
    </head>
    <body style="padding:20px;">
        
        <?php

        require 'common.inc.php';

        $client = new Pagepan\MbdPayClient(MBDPAY_APP_ID, MBDPAY_APP_KEY);

        $openid = $_GET['openid'];

        if ( ! $openid )
        {
            $openid_url = $client->openid('http://192.168.31.2/mbdpay-php/example/wxjs.php');

            echo '<p>正在打开微信支付窗口...</p><script>location.href="' . $openid_url. '";</script>';
        }
        else
        {
            $res = $client->wxjs($openid, 1, '产品说明', 'http://192.168.31.2/mbdpay-php/example/callback_url.php');
            
            if ( $res['code'] === 0 )
            {
                $data = $res['data'];
                
                include 'wxjs-script.php';
            }
            else
            {
                echo $res['message'];
            }
        }
        ?>
        
    </body>
</html>