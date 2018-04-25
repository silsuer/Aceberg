<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/22
 * Time: 18:28
 */


// 设置redis，2个参数设置,均用同一个数据库
function R(){
    $redis= \S\Redis::getInstance();  // 获取单例
    $args = func_get_args();
    switch (func_num_args()){
        case 1:
           if(is_array($args[0])){  // 传入一个数组，批量赋值
               foreach ($args[0] as $k => $v){
                   $redis->set($k,$v);
               }
               return true;
           }
           $v = $redis->get($args[0]);  // 取出
           return $v;
            break;
        case 2:
            $redis->set($args[0],$args[1]);  // 设置
            return true;
            break;
        default:
            return null;
    }
}


// 创建一个路由并返回
function routeInit(){
    return new \S\Route();
}


// 把如果是
function allToString($arg){
    if (is_string($arg)||is_int($arg)) return $arg;
    if(is_object($arg)||is_array($arg)) $arg = allToArray($arg);
    return json_encode($arg);
}

// 把所有都转换为数组
function allToArray($arg){
    if(is_object($arg)){
        $arg = json_decode(json_encode($arg),true);
    }
    foreach ($arg as  $v){
        if(is_object($v)){
            allToArray($v);
        }
    }
    return $arg;
}

/*
  S-Framework 公共函数库
*/
/*C函数，读取用户配置，
   注意：不需要把整个配置文件都读入到一个数组中，会占用内存，在程序中需要用到的地方随时进行读写，所以
   只需要把读过的配置信息存入一个静态数组中即可
 */
// 两个参数是设置 ，一个参数是读取
function C(){
    $conf = \S\Config::getInstance();
    $args = func_get_args();
    switch (func_num_args()) {
        case 0: //0个参数，读取全部配置
            return $conf->getAll();
            break;
        case 1:   //一个参数，则为读取配置信息的值,如果是数组，为动态设置配置信息的值
            if (is_array($args[0])){
                return $conf->setAll($args[0]);
            }
            return $conf->get($args[0]);
            break;
        case 2:   //两个参数，为设置配置信息的值
            //echo "2个参数";
            return $conf->set($args[0],$args[1]);
            break;
        default:
            break;
    }
}


// 设置session
function session(swoole_http_request $request,$parm1,$parm2 = null){
    // 两个参数是读取，三个参数是设置，第一个传入request
    if(is_null($parm2)){  // 读取
        return \S\Session::getValue($request,$parm1);
    }else{
        // 设置
        return \S\Session::setValue($request,$parm1,$parm2);
    }
}


// 获取Template的单例
function temp(){
   return \S\Template::getInstance();
}

// 项目根目录
function root_path(){
    return  dirname(dirname(dirname(__FILE__)));
}

// 操作redis，第一个是数据库编号
function RD(){
    $args = func_get_args();  // 获取参数
    $redis = new \S\Redis($args[0]); // 获取redis实例（非单例）
    switch (count($args)){
        case 2:
            // 获取或者批量设置
            if(is_array($args[1])){
                // 批量设置
                foreach ($args[1] as $k => $v){
                    $redis->set($k,$v);
                }
            }
            // 获取
            return $redis->get($args[1]);
            break;
        case 3:
            // 单独设置
            $redis->set($args[1],$args[2]);
            break;
        case 4:
            // 第四个参数是 删除
            if($args[3]=='delete'){
                $redis->delete($args[1]);  // 传入的第二个参数会被销毁，第三个参数任意
            }
            break;
        default:
            break;
    }
    return true;
}
