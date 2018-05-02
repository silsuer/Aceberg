<?php

namespace Ace\components\a\updateTableConstructs;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

class updateTableConstructs
{
    /* @doc
     * @name: handle
     * @require: $req:全局请求变量|$res:全局响应变量|$arr 要添加的表结构（同模块表字段）
     * @response: 无
     * @description: 添加或修改模块时调用这个组件，在数据库中生成对应的表
     * @more: http://doc.aceberg.org
     */
    public function handle(\swoole_http_request $req = null, \swoole_http_response $res = null, $arr = [])
    {
        $flag = true; // 为true证明可以入库
        // 验证数据
        if($req&&$res){
            $arr = $req->post['data'];
            if($arr['name']==''||$arr['target']==''||$arr['model_id']==0){
                $res->end('');
                return;
            }

            // x向模块表中添加数据
            $insert = [
                'name'=>$arr['name'],
                'target'=>$arr['target'],
                'description'=>$arr['description'],
                'model_id'=>$arr['model_id'],
                'module_id'=>$arr['module_id'],
                'status'=>'使用中',
                'config'=>json_encode($arr['config'])
            ];
            DB::table('modules')->insert($insert);
        }

        // 更新表结构,把整个模块的信息都传过来，从里面解析出数据
        $tableName = $arr['target'];
        $config = $arr['config'];
        if (is_string($config)) {
            $config = json_decode($config, true);
        }
        // 此时config是数组
        if (DB::schema()->hasTable($tableName)) {
            // 有这张表，更新
            $this->updateTable($tableName, $config);
        } else {
            // 没有这张表，创建
            $this->createTable($tableName, $config);
        }
        if($req&&$res){
           $res->end(resJson());
        }
    }

    public function updateTable($tableName, $cols)
    {

        // 更新表，只能添加或者删除不要的列，不能更改字段名，不能更改字段类型
        $add = []; // 添加的列
        $delete = []; // 删除的列

        $list = DB::schema()->getColumnListing($tableName);
        foreach ($cols as $v) {
            // 新表里有，旧表里没有的是新列
            if (!in_array($v['dir'], $list)) {
                $add[] = $v;
            }
        }

        foreach ($list as $v) {
            if (!in_array($v, $cols)) {
                $delete[] = $v;
            }
        }
        // TODO   删除旧列,添加新列
//        DB::table($tableName)->d

    }

    // 建表，第一个是表名，第二个是列的数组
    public function createTable($tableName, $cols)
    {
        DB::schema()->create($tableName, function (Blueprint $table) use ($cols) {
            if (!array_key_exists('id', $cols)) {
                $table->increments('id');  // 如果没有id列的话，加上id列
            }
            foreach ($cols as $v) {
                // 判断是否有type
                if (array_key_exists('type', $v)) {
                    if (array_key_exists('default', $v)) {
                        // 如果有comment
                        if (array_key_exists('comment', $v)) {
                            $table->{$v['type']}($v['dir'])->nullable()->default($v['default'])->comment($v['comment']);
                        } else {
                            $table->{$v['type']}($v['dir'])->nullable()->default($v['default']);
                        }
                    } else if (array_key_exists('comment', $v)) {
                        // 如果有default
                        if (array_key_exists('default', $v)) {
                            $table->{$v['type']}($v['dir'])->nullable()->default($v['default'])->comment($v['comment']);
                        } else {
                            $table->{$v['type']}($v['dir'])->nullable()->comment($v['comment']);
                        }
                    }
                }
                // 判断是否有default

                // 判断是否有comment
            }
        });
    }
}
        