<?php

namespace Ace\components\a\getArticleContent;
use Ace\tags\a\getModuleInfo\getModuleInfo;
use Illuminate\Database\Capsule\Manager as DB;
class getArticleContent
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量|$res:全局响应变量
     * @response:
     * @description: 前端通过get请求这个组件，发送模块id，和页面id，分页处理后返回数据
     * @demo:{{ace.makeUrl('a_getArticleContent')}}?module_id=" + {{info.id}} +"&limit=30"
    });
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function handle(\swoole_http_request $req, \swoole_http_response $res, $arr = [])
    {
        $data = [
            'code'=>0,
            'msg'=>'',
            'count'=>10,
            'data'=>[]
        ];
        $page = 1;
        $limit = 30;
        $module_id = $req->get['module_id'];
         if(array_key_exists('page',$req->get)){
             $page = $req->get['page'];  // 获取是第几页
         }

        if(array_key_exists('limit',$req->get)){
            $limit = $req->get['limit'];  // 获取分页数量
        }
         $a = new getModuleInfo();
         $info = $a->view(['request'=>$req]);
        // 获取数据总量
        $data['count'] = DB::table($info['target'])->count();  // 获取这张表里数据总量
        // 获取需要的数据
        $r = DB::table($info['target'])->limit($limit)->offset($limit*($page-1))->get();

        $data['data'] = allToArray($r);
        $res->end(json_encode($data));

    }
}
        