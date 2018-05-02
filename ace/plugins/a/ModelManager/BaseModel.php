<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/27
 * Time: 16:07
 */

namespace Ace\plugins\a\ModelManager;


use Illuminate\Database\Capsule\Manager as DB;

// 模型基类，所有模型都继承自这个模型
class BaseModel
{
    public $config = []; //必须定义，用来生成配置表中的默认配置项

    // 要存入模型表的数据 name,name_dir,description
    public $info = [];

    public function __construct()
    {
        $data=[];
        foreach ($this->config as $v){
            $data[$v] = $this->{$v};
        }
        $this->config = json_encode($data);  // 把配置文件序列化为字符串
    }


    // 将模型数据入库
    public function install()
    {
//        $name = join('_', explode('/', $this->info['name']));  // a_ArticleContent
        // 如果这个模型存在，提示
        if (DB::table('models')->where('target', $this->info['target'])->exists()) {
            // 插入数据库
            echo "\n 该模型已存在!";
        } else {
            $data = [
                'name'=>$this->info['name'],
                'target'=>$this->info['target'],
                'description'=>$this->info['description'],
                'config'=>$this->config
            ];
            DB::table('models')->insert($data);
        }
    }

}