<?php

namespace Ace\components\a\addArticleContent;

use Ace\components\a\validatePostData\validatePostData;
use Ace\tags\a\getModuleInfo\getModuleInfo;
use Illuminate\Database\Capsule\Manager as DB;
class addArticleContent
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量|$res:全局响应变量,req中必须带有module_id
     * @response: 添加成功|添加失败
     * @description: 前端通过post请求这个组件，发送对文章内容模型要添加的数据，然后此处根据模块id存入数据库
     * @demo:  $.post("{{ace.makeUrl('a_addArticleContent','handle',{'module_id':info.id})}}", {
     * @more: http://doc.aceberg.org
     */
    public function handle(\swoole_http_request $req, \swoole_http_response $res, $arr = [])
    {
        // 根据info对数据进行验证
        $a = new getModuleInfo();
        $info = $a->view(['request' => $req]);
        $v = new validatePostData();
        $d = $v->handle($req,$res,$info);
        $err = $d['err'];
        print_r($d);
        if(empty($err)){
            // 空的，可以入库
            DB::table($info['target'])->insert($d['data']);
            $res->end(resJson());  // 返回插入成功的消息
            return;
        }else{
            // 非空，不可以入库，并且返回错误信息
            $res->end(resJson([$err,'',500]));
            return;
        }

    }
}
        