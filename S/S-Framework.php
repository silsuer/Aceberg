<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/22
 * Time: 11:37
 */

namespace S;



// 引入内置的公共函数
require "Common/functions.php";

// 引入配置类
require "Config.php";

// 引入Redis类
require "Redis.php";

require "Route.php";   // 引入路由类
// 开始注册路由，把所有路由放到一个配置文件中，初始化时构建路由树

