<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/27
 * Time: 13:33
 */

namespace App;


// 插件基类
class BasePlugin
{
    // 插件安装函数
    public function install(){
        // TODO 读取描述文件，检测依赖是否存在，如果存在，继续检测依赖的依赖是否存在
        // TODO 如果不存在，去官方仓库获取
    }

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