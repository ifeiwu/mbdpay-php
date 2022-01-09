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

        $client = new Pagepan\MbdPayClient(MBDPAY_APP_ID, MBDPAY_APP_KEY);

        $openid = $_GET['openid'];

        if ( ! $openid )
        {
            $openid_url = $client->openid('http://192.168.31.2/mbdpay-php/example/wxjs.php');

            echo '<p>正在打开微信支付窗口...</p><script>location.href="' . $openid_url. '";</script>';
        }
        else
        {
            $res = $client->wxjs($openid, 1, '产品说明', 'http://192.168.31.2/mbdpay-php/callback_url.php');
        ?>
        
        <script>
            function onBridgeReady()
            {
               WeixinJSBridge.invoke(
                  'getBrandWCPayRequest', {
                     "appId":"<?php echo $res['appId']; ?>", // 公众号ID，由商户传入     
                     "timeStamp":"<?php echo $res['timeStamp']; ?>", // 时间戳，自1970年以来的秒数     
                     "nonceStr":"<?php echo $res['nonceStr']; ?>", // 随机串     
                     "package":"<?php echo $res['package']; ?>",     
                     "signType":"<?php echo $res['signType']; ?>", // 微信签名方式：     
                     "paySign":"<?php echo $res['paySign']; ?>" // 微信签名 
                  },
                  function (res) {
                      
                      if ( res.err_msg == "get_brand_wcpay_request:ok" )
                      {
                        // 使用以上方式判断前端返回,微信团队郑重提示：
                        // res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
                      } 
               }); 
            }
            
            if ( typeof WeixinJSBridge == "undefined" )
            {
               if ( document.addEventListener )
               {
                   document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
               }
               else if (document.attachEvent)
               {
                   document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
                   document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
               }
            }
            else
            {
               onBridgeReady();
            }
        </script>

        <?php } ?>
        
    </body>
</html>