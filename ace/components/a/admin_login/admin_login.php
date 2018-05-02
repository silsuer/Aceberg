<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/26
 * Time: 17:08
 */

namespace Ace\components\a\admin_login;

use Illuminate\Database\Capsule\Manager as DB;
class admin_login
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量|$res:全局响应变量|$arr:登陆表单信息，包括验证码，用户名，密码
     * @response: 登陆成功|用户名密码不正确|验证码错误
     * @description: 前端通过post请求这个组件，发送后台管理员的帐号密码验证码，经过验证后返回结果
     * @demo: $.post('{{ace.makeUrl('a_admin_login')}}',{data:data},function(d){
                alert(d.info)
              });
     * @more: http://doc.aceberg.org
     */
    public function handle(\swoole_http_request $req, \swoole_http_response $res, $arr = [])
    {
        if(session($req,'phrase')==$req->post['phrase']){
            $name = $req->post['name'];
            $password = $req->post['password'];
            $user = DB::table('admin')->where('name',$name)->first();
            $user = allToArray($user);
            if(empty($user)){
                $res->end(resJson(["用户名或密码不正确！",500]));
            }else{
                if($user['password']==md5($password)){
                    // 查找成功，写入id
                    session($req,'id',$user['id']);   // 把id写入session
                    session($req,'name',$user['name']);   // 把id写入session
                    $res->end(resJson());
                }else{
                    $res->end(resJson(["用户名或密码不正确！",500]));
                }
            }
        }else{
            $res->end(resJson(["验证码错误！",500]));
        }
    }

}