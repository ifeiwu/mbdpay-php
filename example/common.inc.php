<?php

define('ROOT_PATH', dirname(__DIR__) . '/');

// 所有错误和异常记录
ini_set('error_reporting', E_ALL & ~E_NOTICE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', ROOT_PATH . 'error.log');

// https://mbd.pub/dev 进入【控制面板->开发设置】获取APP参数
define('MBDPAY_APP_ID', '219425492613125');
define('MBDPAY_APP_KEY', '9db8e42d34e0858ca1572797846677c7');

require_once ROOT_PATH . 'vendor/autoload.php';

require_once ROOT_PATH . 'src/MbdPayClient.php';