<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/22
 * Time: 10:44
 */


require "./vendor/autoload.php";
class Server {

    public $routesList = [];  // 路由数组

    public function __construct()
    {
        // 注册路由,做所有初始化的功能
        $this->routesList["/admin"] = routeInit()->setMethod("get")->setTarget("App\Controller\Controller@welcome");
    }

    public function start(){
        // 开启一个http服务
        $http = new swoole_http_server("0.0.0.0",35335);
        $http->on("request",function ($request,$response){
            // 一个请求，创建一个对象，把request和respone放进去，
            // 根据请求，解析url，拼装成request对象和redis对象
            // 如果注册了路由，才会去寻找
            if(array_key_exists($request->server['request_uri'],$this->routesList)){
                // 存在这个路由，直接执行handle函数，执行对应控制器里的方法
                $this->routesList[$request->server['request_uri']]->handle($request,$response);
                // 响应只能是一个字符串
            }else{
                $response->status(404);
                $response->end("页面未找到！");
            }
        });
        $http->start();
    }

}

$ace = new Server();
$ace->start();


