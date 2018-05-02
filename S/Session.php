<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/24
 * Time: 11:55
 */

namespace S;

// 使用redis保存session
class Session
{
    private static $instance;
//    private static $dbNum = 13; // session存储的数据库编号
    public $key;   // 存储唯一键
    public $values = [];  // 存储session中的值
    public $expire;   // session有效期

    public static $sessionMap = [];  // 建立一个默认的数组，存储session

    // 获取单例
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // 传入一个id，从数组或者redis中取出对象，判断这个对象是否过期，如果过期，返回false，否则返回对象
    public static function getObj($sessionID)
    {
        $driver = C('SESSION_DRIVER');  // 获取驱动
        if ($driver == "ARRAY") {
            // 数组形式取得
            return self::$sessionMap[$sessionID];  // 数据都是以序列化之后的字符串形式存储的
        } else if ($driver == "REDIS") {
            // 从redis里取出数据
//            return unserialize(RD(self::$dbNum, $sessionID));
            return unserialize(R($sessionID));
        } else {
            return null;
        }
    }

    public function setObj(Session $obj)
    {
        $driver = C('SESSION_DRIVER');  // 获取驱动
        if ($driver == "ARRAY") {
            // 数组形式取得
           return  self::$sessionMap[$obj->key] = $obj;
        } else if ($driver == "REDIS") {
            // 从redis里取出数据
            return R($obj->key,serialize($obj));
        } else {
            return false;
        }
    }

    public static function destory($sessionID){
        // 根据sessionid销毁session
        $driver = C('SESSION_DRIVER');  // 获取驱动
        if ($driver == "ARRAY") {
            // 数组形式取得
              unset(self::$sessionMap[$sessionID]);
        } else if ($driver == "REDIS") {
            // 从redis里删除数据
             RD(15,$sessionID,null,'delete');
        }
    }

    public static function getValue(\swoole_http_request $request,$key){
        $driver = C('SESSION_DRIVER');  // 获取驱动
        if ($driver == "ARRAY") {
            // 数组形式取得
            if(array_key_exists($request->cookie[C('SESSION_NAME')],self::$sessionMap)){
                // 如果存在
                if(array_key_exists($key,self::$sessionMap[$request->cookie[C('SESSION_NAME')]]->values)){
                    return self::$sessionMap[$request->cookie[C('SESSION_NAME')]]->values[$key];  // 返回值
                }else{
                    return null;
                }
            }else{
                return null;
            }
        } else if ($driver == "REDIS") {
            // 从redis取出数据
            $sess = self::getObj($request->cookie[C('SESSION_NAME')]);  // 获取对象

            if(is_null($sess)) return null;
              // 返回她的key
            if(array_key_exists($key,$sess->values)){
                return $sess->values[$key];
            }else{
                return null;
            }
        }
    }

    public static function setValue(\swoole_http_request $request,$key,$value){
        $driver = C('SESSION_DRIVER');  // 获取驱动
        if ($driver == "ARRAY") {
            // 数组形式取得
            $s = self::$sessionMap[$request->cookie[C('SESSION_NAME')]]; //取出挂载的数据
            $s->values[$key] = $value;
            return true;
        } else if ($driver == "REDIS") {
            // 从redis取出数据
            $sess = self::getObj($request->cookie[C('SESSION_NAME')]);  // 获取对象
            if(is_null($sess)) return null;
            $sess->values[$key] = $value;  // 返回她的key
//            重新设置回去
            return R($request->cookie[C('SESSION_NAME')],serialize($sess));
        }
    }
}