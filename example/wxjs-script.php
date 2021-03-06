<script>
    function onBridgeReady()
    {
        WeixinJSBridge.call('hideOptionMenu');
        
        WeixinJSBridge.invoke('getBrandWCPayRequest', {
             "appId":"<?php echo $data['appId']; ?>", // 公众号ID，由商户传入
             "timeStamp":"<?php echo $data['timeStamp']; ?>", // 时间戳，自1970年以来的秒数
             "nonceStr":"<?php echo $data['nonceStr']; ?>", // 随机串
             "package":"<?php echo $data['package']; ?>",
             "signType":"<?php echo $data['signType']; ?>", // 微信签名方式：
             "paySign":"<?php echo $data['paySign']; ?>" // 微信签名
        },
        function (res) {
          
            if ( res.err_msg == "get_brand_wcpay_request:ok" )
            {
                WeixinJSBridge.call('closeWindow');
              
                // 使用以上方式判断前端返回，微信团队郑重提示：
                // res.err_msg 将在用户支付成功后返回 ok，但并不保证它绝对可靠。
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