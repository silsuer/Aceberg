<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/27
 * Time: 16:07
 */

namespace Ace\models\a\ArticleContent;

// 文章内容模型
use Ace\plugins\a\ModelManager\BaseModel;

class ArticleContent extends BaseModel
{

    public $info = [
        'name'=>'文章内容模型',  // 名称
        'author'=>'silsuer',
        'target'=>'a_ArticleContent',
        'description'=>'核心模型之一，用于进行对可复用资源的增删改查',
        'logo'=>'logo.png'
    ];


    public $map = [
        [
            'name'=>'内容列表',
            'page'=>'content'
        ],
        [
            'name'=>'待审核',
            'page'=>'review'
        ],
        [
            'name'=>'回收站',
            'page'=>'recycle_bin'
        ]
    ];



    // 定义默认配置项
    public $config = ["title","subject","content","time","tags","status","password","review"];
    public $title = [
        'name' => '标题',
        'dir' => 'title',
        'comment'=> '每篇文章的标题',
        'type' => 'string',
        'view'=>'input',
        'validate'=>'required',
        'show'=>1,
    ];
    public $subject = [
        'name' => '主题',
        'dir' => 'subject',
        'comment'=> '每篇文章的简介',
        'type' => 'text',
        'view'=>'input'
    ];
    public $content = [
        'name' => '内容',
        'dir' => 'content',
        'comment'=> '文章内容',
        'type' => 'mediumText',
        'view'=>'markdown',
        'validate'=>'required'
    ];
    public $time = [
        'name' => '发布时间',
        'dir' => 'time',
        'comment'=> '文章发布的时间',
        'type' => 'string',
        'view'=>'timer',
        'validate'=>'required',
        'show'=>1,
    ];

    public $tags = [
        'name' => '标签',
        'dir' => 'tags',
        'comment'=> '文章个性化标签',
        'type' => 'string',
        'view'=>'input',
    ];
    public $status = [
        'name' => '状态',
        'dir' => 'status',
        'comment'=> '文章所处的状态',
        'type' => 'string',
        'default'=> '已发布',
        'view'=>'select->草稿|等待审核|已发布|密码验证|隐藏|回收站',
        'validate'=>'required',
        'show'=>1,
    ];
    public $password = [
        'name' => '密码',
        'dir' => 'password',
        'comment'=> '加密文章的密码',
        'type' => 'string',
        'view'=>'password',
    ];
    public $review = [
        'name' => '审核',
        'dir' => 'review',
        'comment'=> '文章是否经过审核',
        'type' => 'string',
        'view'=>'radio->是|否',
        'validate'=>'required'
    ];


}