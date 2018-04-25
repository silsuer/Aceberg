<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/22
 * Time: 18:27
 */

namespace S;

use Predis\Client;

class Config
{
    //这个数组是用来存放配置值的
    private $config = [];
    private $redisConfig = [];
    //这个变量用来存放单例的
    private static $instance;

//    public $value;
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Config constructor. 构造函数 创建实例时就引入配置文件，并合并，给$config赋值
     */
    private function __construct()
    {
        // 引入配置文件
        $config = json_decode(file_get_contents(root_path() . '/.env'),true);

        // 根据配置文件，建立redis数据库，把数据存入
        $cfg = [
            'host' => $config['REDIS_HOST'],
            'port' => $config['REDIS_PORT'],
            'database' => $config['REDIS_DB']
        ];
        $redis = new Client($cfg);

        foreach ($config as $k => $v) {
            $redis->set($k,$v);
        }
        $this->config = $config;  // 把这个配置文件保存在内存中一份
    }

    // 设置配置信息
    public function set($key,$value){
        $this->config[$key] = $value;
        return true;
    }
    // 读取配置
    public function get($key){
        return $this->config[$key];
    }
    public function getAll(){
        return $this->config;
    }

    // 批量设置配置
    public function setAll($arr){
        foreach ($arr as $k => $v){
            $this->set($k,$v);
        }
        return true;
    }
}