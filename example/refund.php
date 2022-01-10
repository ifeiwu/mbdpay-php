<html>
    <head>
        <title>退款</title>
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
        
        $res = $client->refund('xxxxxxxxxxxxxxxxxxx');

        if ( $res['code'] === 0 )
        {
            echo $res['message'];
        }
        else
        {
            echo $res['message'];
        }
        ?>
        
    </body>
</html>