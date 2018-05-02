<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/5/2
 * Time: 11:38
 */

namespace App;


class Instance
{
    /**
     * @var 类唯一标示
     */
    public $id;

    /**
     * 构造函数
     * @param string $id 类唯一ID
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * 获取类的实例
     * @param string $id 类唯一ID
     * @return Instance
     */
    public static function getInstance($id)
    {
        return new self($id);
    }
}