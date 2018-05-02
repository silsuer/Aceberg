<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/29
 * Time: 22:21
 */

namespace Ace\plugins\a\MenuManager;

use Illuminate\Database\Capsule\Manager as DB;
use App\BasePlugin;
use Illuminate\Database\Schema\Blueprint;

class MenuManager extends BasePlugin
{
    public function install()
    {
        // 菜单管理插件，创建一个菜单表
        if(DB::schema()->hasTable('admin_menus')){
            echo "\n 当前数据库中已存在admin_menus表，已跳过创建......";
        }else{
            DB::schema()->create('admin_menus',function (Blueprint $table){
               $table->increments('id');
               $table->string('title')->comment('菜单名');
               $table->string('icon')->nullable()->default('')->comment('图标');
               $table->text('href')->nullable()->comment('这个图标指向的链接');
               $table->integer('spread')->default(0)->comment('是否默认打开');
               $table->integer('pid')->default(0)->comment('上级菜单id，此处自关联自己，为0则是顶级菜单');
            });
        }

        // 添加一些基础菜单
        // 需要依赖的功能  添加菜单，修改菜单 删除菜单 获取菜单

        parent::install();
        echo "\n 菜单管理插件安装完成！";
    }

}