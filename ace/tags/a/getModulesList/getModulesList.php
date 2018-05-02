<?php

namespace Ace\tags\a\getModulesList;

use Illuminate\Database\Capsule\Manager as DB;
use S\Template;

class getModulesList
{

    /* @doc
     * @name: view
     * @require: 空
     * @response:
     * @description: 从数据库中获取全部模型列表，返回自关联查询后的结果
     * @demo: {% set info = ace.tag('a_getModulesList') %}
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function view($arr = [])
    {
        $res = [];
        // 获取自关联数据,这里为了模块的多重嵌套，不能使用表的自关联，需要把数据全部取出来之后重新进行关联
        $data = DB::table('modules')->get();
        $data = allToArray($data);

        // 获取操作 内容列表/待审核/回收站等等
        foreach ($data as $k=>$v){
            $model_id = $v['model_id']; // 获取模型id
            $model = allToArray(DB::table('models')->where('id',$model_id)->first());  // 根据模型id获取模型信息
            $model_name = $model['target'];
            if(array_key_exists($model_name,Template::$modelsTree)&&array_key_exists('namespace',Template::$modelsTree[$model_name])){ // 存在这个模型
                // new 一个模型，获取map变量
                $a = new Template::$modelsTree[$model_name]['namespace']();
                $data[$k]['map'] = $a->map;
                $data[$k]['model_name'] = $model_name;//得到模型名
            }
        }

        // 因为前台显示的问题，不能写成迭代的，只能固定，最多支持三级模块嵌套
        // 顶级模块
        foreach ($data as $k => $v) {
            if ($v['module_id'] == 0) {
                $res[] = $v;
                unset($data[$k]);
            }
        }

        // 二级模块
        foreach ($data as $k => $v){
            foreach ($res as $kk => $vv){
                if($v['module_id']==$vv['id']){
                    $res[$kk]['sub'][] = $v;
                    unset($data[$k]);
                }
            }
        }

        // 三级模块
        foreach ($data as $k=>$v){
            foreach ($res as $kk => $vv){
                if(array_key_exists('sub',$vv)){
                    foreach ($vv['sub'] as $kkk => $vvv){
                        if($v['module_id']==$vvv['id']){
                            $res[$kk]['sub'][$kkk]['sub'][] = $vvv;
                        }
                    }
                }
            }
        }

        return $res;
    }


}
        