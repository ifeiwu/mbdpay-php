<html>
    <head>
        <title>callback_url</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta name="format-detection" content="email=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
    </head>
    <body style="padding:20px;">
        
        <h3>回调 URL 参数：</h3>
        
        <p>
            <?php
                require 'common.inc.php';
                
                dump($_GET);
            ?>
        </p>
        
    </body>
</html>