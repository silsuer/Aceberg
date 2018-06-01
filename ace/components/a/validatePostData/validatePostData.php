<?php

namespace Ace\components\a\validatePostData;

use Ace\tags\a\getModuleInfo\getModuleInfo;
use App\Validate;

class validatePostData
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量|$res:全局响应变量,req中必须带有module_id,post的值键必须为data|$arr是模块信息
     * @response: 验证后（过滤后的数据）|err 验证中失败的信息
     * @description: 一般通过其他组件调用该组件，用来对传来的要添加的数据进行过滤和验证，返回验证信息
     * @demo:   $v = new validatePostData();
     * $v->handle($req,$res);
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function handle(\swoole_http_request $req, \swoole_http_response $res, $arr = [])
    {

        // 返回后要先检查err，如果不为空，就不可以入库，为空的话，将data中的数据入库
        $d = [
            'data' => [],
            'err' => []
        ];

        $info = $arr;
        $form = $req->post['data'];

        foreach ($info['config'] as $col) {
            $validate_role = explode('|', $col['validate']);
            $view = explode('->', $col['view']);
            if ($view[0] == 'markdown') $form[$col['dir']] = $form['content-markdown-doc'];
            if ($view[0] == 'ueditor') $form[$col['dir']] = $form['content-html'];  // 把数据放入真实的数据中
            // 判断数据
            $validation = explode('|', $col['validate']);
            if (in_array('required', $validation)) {
                if (array_key_exists($col['dir'], $form)) {
                    foreach ($validation as $vv) {
                        // 记录验证规则
//                        print_r($vv);
//                        print_r($form[$col['dir']]);
                        $r = Validate::validate($vv, $form[$col['dir']]);
                        if (is_bool($r)&& $r === true) {
                            $d['data'][$col['dir']] = $form[$col['dir']];
                        } else {
                            $d['err'][] = $col['name'] . $r;
                        }
                    }
                } else {
                    // 抛出必填项的错误
                    $d['err'][] = $col['name'] . '为必填项';
                    continue;
                }
            }


        }
        return $d;
    }
}
        