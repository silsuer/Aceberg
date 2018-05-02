<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/27
 * Time: 13:34
 */

namespace App;

// 模型基类
class BaseModel
{

    // 模型基本信息
    public $info = [];

    public $set = '';  // 是否开启set，如果不为空，会在已安装模型下出现一个设置按钮，点击后进入设置项

    // 定义默认配置项
    public $config = [];
    /**
     * 魔术方法
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }
}