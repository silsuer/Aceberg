<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/24
 * Time: 10:27
 */

class Server
{
    public $routesList = [];  // 路由数组

    public function __construct()
    {
        // 注册路由,做所有初始化的功能
        $this->routesList["/admin"] = routeInit()->setMethod("get")->setTarget("App\Controller\Controller@welcome");
        $this->routesList["/home"] = routeInit()->setMethod("get")->setTarget("App\Controller\Controller@home");
    }


    public function start()
    {
        // 显示欢迎页面
        $this->welcome();
        // 开启一个http服务
        $http = new swoole_http_server("0.0.0.0", 35335);
        $http->on("request", function ($request, $response) {
             if ($request->server['request_uri']=='/favicon.ico'){
                 $response->end("");
                 return;
             }
             if(C('SESSION_START')==1){
                 // 设置session
                 $rq = $this->sessionInit(["request" => $request, "response" => $response]);
                 $request = $rq["request"];
                 $response = $rq["response"];  // 把执行结果重新拆分赋值
             }



            // 一个请求，创建一个对象，把request和respone放进去，
            // 根据请求，解析url，拼装成request对象和redis对象
            // 如果注册了路由，才会去寻找
            if (array_key_exists($request->server['request_uri'], $this->routesList)) {
                // 存在这个路由，直接执行handle函数，执行对应控制器里的方法
                $this->routesList[$request->server['request_uri']]->handle($request, $response);
            } else {
                // 解析uri
                \S\Template::parseUrl($request,$response);
            }
        });
        $http->start();
    }

    private function welcome()
    {
        echo "    _            _                      \n";
        echo "   / \   ___ ___| |__   ___ _ __ __ _   \n";
        echo "  / _ \ / __/ _ \ '_ \ / _ \ '__/ _` |  \n";
        echo " / ___ \ (_|  __/ |_) |  __/ | | (_| |  \n";
        echo "/_/   \_\___\___|_.__/ \___|_|  \__, |  \n";
        echo "                                |___/   \n";
    }

    private function sessionInit($rq)
    {
        if (C('SESSION_START') != 1) return $rq;  // 如果配置项没开启，直接返回

        $request = $rq["request"];
        $response = $rq["response"];

        // 如果开启了
        // 先判断cookie里是否有设置的session名
        // 如果没有，挂载一个新的session对象
        if (!isset($request->cookie[C('SESSION_NAME')])) {
            // 不存在
           $rrq = $this->setSess($request,$response);
           return $rrq;
        } else {
            // 如果有，检测是否过期，如果过期，则销毁session，没过期的话，更新session有效期
            $session = \S\Session::getObj($request->cookie[C('SESSION_NAME')]);  // 获取值
            if(is_null($session)){
                $rrq = $this->setSess($request,$response);
                return $rrq;
            }
            if ($session->expire > time()) {  // 没过期
                $session->expire = time() + C('SESSION_LIFE_TIME');
                $response->rawCookie(C('SESSION_NAME'), $session->key, time() + C('SESSION_LIFE_TIME'));
            } else {  // 过期，销毁session
                $session->destory($session->key);
            }
        }
        return ["request" => $request, "response" => $response];  // 返回执行成功的数据
    }

    private function setSess($request,$response){

        // 生成一个唯一id
        $key = uniqid("lhb", true);  // 生成唯一id
        $session = new \S\Session();
        $session->key = $key;
        $session->expire = time() + C('SESSION_LIFE_TIME');  // 添加有效期
        $session->setObj($session);  // 存储session
        $request->cookie[C('SESSION_NAME')] = $key;
        // 在数据库里加入完成，设置cookie
        $response->rawCookie(C('SESSION_NAME'), $key, time() + C('SESSION_LIFE_TIME'));
        return ["request"=>$request,"response"=>$response];
    }
}