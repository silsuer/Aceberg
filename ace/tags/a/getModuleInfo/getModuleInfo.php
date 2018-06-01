<?php

namespace Ace\tags\a\getModuleInfo;
use Illuminate\Database\Capsule\Manager as DB;
class getModuleInfo
{
    /* @doc
     * @name: view
     * @require: $arr中包括request字段，是swoole的请求对象
     * @response:
     * @description: 根据传来的模块id，从数据库中拿到模块信息，并返回
     * @demo: {% set info = ace.tag('a_getModuleInfo','view',{'request':request}) %}
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function view($arr = [])
    {
        $req = $arr['request'];  // 获得请求
        $module_id = $req->get['module_id']; // 获取模型id
        $res = DB::table('modules')->where('id',$module_id)->first();
        $res = allToArray($res);
        if(array_key_exists('config',$res)){
            $res['config'] = json_decode($res['config'],true);
        }
        return $res;
    }
}
        