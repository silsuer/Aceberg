<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/23
 * Time: 21:41
 */
use Illuminate\Database\Capsule\Manager as DB;

// 用来初始化数据库操作
$db = new DB();
$dsn = [
    'driver' => C('DB_DRIVER'),  // 数据库驱动
    'host' => C('DB_HOST'),   // 数据库主机名
    'database' => C('DB_NAME'),  // 数据库名
    'username' => C('DB_USER_NAME'),
    'password' => C('DB_PASSWORD'),
    'charset' => C('DB_CHARSET'),   // 字符集
    'collation' => C('DB_COLLATION'),  // 排序规则
    'prefix' => C('DB_TABLE_PREFIX') // 表前缀
];
$db->addConnection($dsn);  // 建立连接
$db->setAsGlobal();  // 设置全局访问
$db->bootEloquent();  // 启动
