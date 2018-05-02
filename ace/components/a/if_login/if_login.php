<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/26
 * Time: 17:08
 */

namespace Ace\components\a\if_login;


class if_login
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量|$res:全局响应变量|$arr['url']:登陆完成后要跳转的页面(选填)
     * @response: 重定向到登陆页面
     * @description: 前端调用这个组件，判断是否登陆，如果未登录，则跳转到登陆页面
     * @demo:  {{ ace.handle('a_if_login',request,response) }}
     * @more: http://doc.aceberg.org
     */
    public function handle($req, \swoole_http_response $res, $arr = [])
    {
        $url = '/p.a_AdminManager.login';
        if (array_key_exists('url', $arr)) {
            $url = $arr['url'];
            echo "已经登陆\n";
        }
        if (is_null(session($req, 'id'))) {
            $res->header("Location", $url);
            $res->status(302);
        }
    }
}