<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/5/1
 * Time: 21:28
 */

namespace Ace\models\a\Associator;

use Illuminate\Database\Capsule\Manager as DB;
use Ace\plugins\a\ModelManager\BaseModel;
use App\Anchor;
use Illuminate\Database\Schema\Blueprint;

class Associator extends BaseModel
{
    public $info = [
        'name' => '会员模型',  // 名称
        'author' => 'silsuer',
        'target' => 'a_Associator',
        'description' => '核心模型之一，后台管理员模块即依托该模型建立，也可以用它搭建前台用户模块',
        'logo' => 'logo.png'
    ];

    public $map = [
        [
            'name' => '会员列表',
            'page' => 'list'
        ],
        [
            'name'=>'设置',
            'page'=>'setting'
        ]
    ];

    // 用户名，密码，头像，上次登陆时间
    public $config = ["username", "password", "avatar", "last_login_time"];

    public $username = [
        'name' => '用户名',
        'dir' => 'username',
        'comment' => '用户名',
        'type' => 'string',
        'view' => 'input',
        'validate' => 'required',
        'show' => 1,
    ];

    public $password = [
        'name' => '密码',
        'dir' => 'password',
        'comment' => '密码，使用md5加密',
        'type' => 'string',
        'view' => 'password',
        'validate' => 'required',
    ];
    public $avatar = [
        'name' => '头像',
        'dir' => 'avatar',
        'comment' => '头像，给一个默认头像',
        'type' => 'string',
        'view' => 'upload_simple_img',
        // mysql默认是test不能设置默认值的
        'default' => 'http://ov56xbfbe.bkt.clouddn.com/TIM%E5%9B%BE%E7%89%8720180419184354.jpg'
    ];

    public $last_login_time = [
        'name' => '上次登陆时间',
        'dir' => 'last_login_time',
        'comment' => '上次登陆时间',
        'type' => 'string',
        'view' => 'timer',
    ];

    public function install()
    {
        // 如果没有这张表的话，建立
        if(!DB::schema()->hasTable('associator_config')){
            DB::schema()->create('associator_config',function (Blueprint $table){
               // 模块表名，模块id，模块配置
                $table->increments('id');
                $table->string('table')->comment('会员模块对应的表名');
                $table->integer('module_id')->comment('会员模块对应的id');
                $table->text('config')->nullable()->comment('模块的配置项，比如登陆时的字段，注册字段，辅助登陆方式等');
            });
        }else{
            echo "\n 存在accociator_config会员模型配置表，已跳过......";
        }
        // 安装的时候，建立一张存储每一个会员模块配置的表，在添加模块的时候，触发一个函数，在模块配置表中也加一项，默认写一些配置
        Anchor::mount('after_add_module',function (\swoole_http_request $request = null){
           // 添加完成模块后触发，初始化添加完成的模块的配置信息  遍历模块表，根据模块表搜索会员模块配置表
            
        });
        parent::install();
    }
}