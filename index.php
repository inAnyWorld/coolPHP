<?php
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.6.0','<'))  die('require PHP > 5.6.0 !');
// 应用目录为当前目录
define('APP_PATH', __DIR__ . '/');
// 开启调试模式
define('APP_DEBUG', true);

// 加载框架文件
require(APP_PATH . 'CoolPHP/CoolPHP.php');
//runtime目录 
define('RUNTIME_PATH',APP_PATH.'/Runtime/');
// 加载配置文件
$config = require(APP_PATH . 'Config/config.php');
// 实例化框架类
(new CoolPHP\CoolPHP($config))->run();