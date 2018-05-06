<?php

namespace Ace\components\a\getModuleConfig;

use Illuminate\Database\Capsule\Manager as DB;

class getModuleConfig
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量:包括model_id和module_id|$res:全局响应变量|$arr
     * @response: array 数组，config字段配置
     * @description: 前端通过get请求这个组件，根据传来的模型id，模块id，返回字段配置
     * @demo: $.post('{{ace.makeUrl('a_getModuleConfig')}}',{data:data},function(d){
     * alert(d.info)
     * });
     * @more: http://doc.aceberg.org
     */
    public function handle(\swoole_http_request $req, \swoole_http_response $res, $arr = [])
    {
        // 如果未登录，返回空
        if (!session($req, 'id')) $res->end("");
        // 传入模型id，模块id，获取配置信息
        $arr = $req->get;
        $data = [
            'code' => 0,
            'msg' => "",
            'count' => 1000,
            'data' => []
        ];




        if (array_key_exists('model_id', $arr) && array_key_exists('module_id', $arr)) {
            $model_id = $arr['model_id'];
            $module_id = $arr['module_id'];
            // 如果有当前模块id，判断当前模块的上级模块id，模型id和传入的id是否一致，一致的话返回当前模块配置，否则返回新的配置
            if (array_key_exists('current_module_id', $arr)) {  // 修改模块
                $info = allToArray(DB::table('modules')->where('id',$arr['current_module_id'])->first());
                if($model_id==$info['model_id']&&$module_id==$info['module_id']){  // 完全相同，返回当前模块配置，否则继续往下走
                    $data['data'] = $this->makeObj($info['config']);
                    $res->end(json_encode($data));  // 返回配置
                    return;
                }
            }


            // 如果存在模块id，并且模块id对应的模型和选择的模型相同，那么就是以模块配置为准，否则，以选择的模型配置为准

            $model = allToArray(DB::table('models')->where('id', $model_id)->first());
            if ($module_id != 0) {
                // 判断选择模块对应的模型id和这个模型id是否相同
                $module = allToArray(DB::table('modules')->where('id', $module_id)->first());
                if ($module['model_id'] == $model_id) {
                    // 返回模块配置
                    $data['data'] = $this->makeObj($module['config']);
                    $res->end(json_encode($data));
                    return;
                }
            }
            // 返回模型配置
            $data['data'] = $this->makeObj($model['config']);
            $res->end(json_encode($data));
            return;
        } else {
            $res->end("");
        }
    }

    // 根据传入的配置信息，组装成对象， 名称、英文标识、字段配置
    private function makeObj($config)
    {
        $jsons = [];
        $data = json_decode($config, true);
        foreach ($data as $k => $v) {

            $json = [
                'name' => '',
                'dir' => '',
                'config' => ''
            ];
            if (array_key_exists('name', $v)) $json['name'] = $v['name'];
            if (array_key_exists('dir', $v)) $json['dir'] = $v['dir'];
            $json['config'] = json_encode($v);
            $jsons[] = $json;
        }
        return $jsons;
    }
}
        