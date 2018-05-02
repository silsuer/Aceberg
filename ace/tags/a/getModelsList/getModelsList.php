<?php

namespace Ace\tags\a\getModelsList;
use Illuminate\Database\Capsule\Manager as DB;
class getModelsList
{
    /* @doc
     * @name: view
     * @require: 空
     * @response: data[]
     * @description: 获取本地模型列表
     * @demo: {% set info = ace.tag('a_getModelsList') %}
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function view($arr = [])
    {
        $data = [];  // 要返回的数据
        // 扫描本地模型文件夹，把信息返回
        $dir = scandir(ace_path() . '/models');
        foreach ($dir as $author) {
            if ($author == '.' || $author == '..') continue;
            $modelsDirs = scandir(ace_path() . '/models/' . $author);
            foreach ($modelsDirs as $modelsDir) {
                $desPath = ace_path() . '/models/' . $author . '/' . $modelsDir . '/description.json';
                if (file_exists($desPath)) {  // 文件存在，直接读取
                    $config = json_decode(file_get_contents($desPath), true);
                    $config['belong'] = $author; // 属于哪个文件夹
                    $data[] = $config;
                }
            }
        }
        return $data;  // 返回数据
    }

    /* @doc
     * @name: installedList
     * @require: 空
     * @response: data[]
     * @description: 获取已安装模型列表
     * @demo: {% set info = ace.tag('a_getModelsList','installedList') %}
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function installedList(){
        $a = DB::table('models')->get();
        foreach ($a as $value){
            // 实例化每一个模型，将里面的可显示项计算出来
        }
        return $a;
    }
}
        