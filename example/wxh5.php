<html>
    <head>
        <title>微信 H5 支付</title>
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
        
        $res = $client->wxh5(1, '产品说明');

        if ( $res['code'] === 0 )
        {
            echo '<p>正在打开微信支付窗口...</p><script>location.href="' . $res['data']. '";</script>';
        }
        else
        {
            echo $res['message'];
        }
        ?>
        
    </body>
</html>