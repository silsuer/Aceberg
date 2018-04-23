<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/23
 * Time: 15:26
 */

namespace S;


// 路由列表，使用数组保存所有路由信息
use Swoole\Mysql\Exception;

class Route
{
    private $method = "Get" ;  // 方法，默认是get方法
    private $target;         // 指向的控制器和方法
    private $middleware;    // 中间件

    private $controller;  // 从target中解析出来的控制器名
    private $func;          // 从target中解析出来的要执行的控制器方法名

    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    public function getMethod(){
        return $this->method;
    }

    public function setTarget($target){
        $arr = explode('@',$target);
        if (count($arr)!=2) return false;
        $this->controller = $arr[0];
        $this->func = $arr[1];
        $this->target = $target;
        return $this;
    }

    public function getTarget(){
        return $this->target;
    }

    public function setMiddleware($middlewares){
        $this->middleware = $middlewares;
        return $this;
    }

    public function getMiddleware(){
        return $this->middleware;
    }

    // 执行这个路由的方法,传入一个自己封装的Request对象，返回一个自己封装的响应对象
    public function handle(\swoole_http_request $request,\swoole_http_response $response){
         $controller = new $this->controller();
         $res = $controller->{$this->func}($request,$response);   // 执行控制器对应的函数
         $res = allToString($res);
         $response->end($res);
    }
}