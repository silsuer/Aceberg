<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/5/1
 * Time: 21:28
 */

namespace Ace\models\a\Associator;


use Ace\plugins\a\ModelManager\BaseModel;

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
}