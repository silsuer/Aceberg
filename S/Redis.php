<?php
/**
 * Created by PhpStorm.
 * User: liuho
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
        // 这里写redis连接操作
        // php数组是哈希表
        // 建立Redis连接
        $config = [
            'host' => C('REDIS_HOST'),
            'port' => C('REDIS_PORT'),
            'database' => C('REDIS_DB')
        ];
        $this->redis = new Client($config);
    }

    // 把数据存入redis
    public function set($key, $value)
    {
         $this->redis->set($key,$value);
    }

    public function get($key){
       return  $this->redis->get($key);

    }
}