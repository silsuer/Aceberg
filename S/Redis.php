<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/23
 * Time: 14:15
 */

namespace S;


// 操作Redis
use Predis\Client;

class Redis
{
//    public $redisCoreConfig
    public static $instance;
    private $redis;

    public static function getInstance()
    {  // 单例模式
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $args = func_get_args();
        if(count($args)!=0){
            // 传入的是数据库编号
            $num = $args[0];
        }else{
            $num = C('REDIS_DB');
        }
        // 这里写redis连接操作
        // php数组是哈希表
        // 建立Redis连接
        $config = [
            'host' => C('REDIS_HOST'),
            'port' => C('REDIS_PORT'),
            'database' => $num
        ];
        $this->redis = new Client($config);  // 建立数据库连接
    }

    // 把数据存入redis
    public function set($key, $value)
    {
         $this->redis->set($key,$value);
    }

    public function get($key){
       return  $this->redis->get($key);
    }

    public function delete($key){
        $this->redis->del($key);
    }
}