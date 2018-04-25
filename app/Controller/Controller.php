<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/23
 * Time: 16:58
 */

namespace App\Controller;

class Controller
{
    public function welcome($req, \swoole_http_response $res)
    {

        // 试试Twig
        session($req,"aaa", $req->get["name"]);
        return "设置了aaa为" .  $req->get["name"];
//        $loader = new \Twig_Loader_Filesystem(root_path().'/ace/themes/default/html');
//        $twig = new \Twig_Environment($loader);
//       return $twig->loadTemplate("index.html")->render(array('the' => 'variables', 'go' => 'here'));
    }

    public function home($req, $res)
    {
       return "取出了aaa为" . session($req,"aaa");
    }


}

