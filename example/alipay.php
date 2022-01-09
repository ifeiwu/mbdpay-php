<html>
    <head>
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

        require ROOT_PATH . 'MbdPayClient.php';

        $client = new pagepan\MbdPayClient(MBDPAY_APP_ID, MBDPAY_APP_KEY);
        
        echo $client->alipay('http://192.168.31.2/mbdpay-php/callback_url.php', 1, '产品说明', );

        ?>
        
    </body>
</html>