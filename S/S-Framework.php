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


//echo  root_path(); die();

// 引入配置类
require "Config.php";

// 引入Redis类
require "Redis.php";

require "Route.php";   // 引入路由类
// 把所有路由放到一个配置文件中，初始化时构建路由树

// 引入 Eloquent ORM
require "ORM.php";

require "Session.php";

require "Template.php";