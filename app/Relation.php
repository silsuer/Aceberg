<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/29
 * Time: 10:23
 */

namespace App;
use Illuminate\Database\Capsule\Manager as DB;

// 关联，对eloquent进行二次封装，进行数据库查询的时候多查一次关联关系
class Relation
{
    /*
     * 查询数据库的时候，调用这里的方法，将会在查询之前先查询是否存在关联关系
     * 如果存在关联关系，会连带关联关系中的数据一起查出来
     * 否则直接进行查询
     * 根据属性自动拼接sql语句，然后调用DB的方法，执行语句
     * DB::table('tableName')->where('id'=>5)->get()
     * DB::table('tableName')->where('id'=>5)->first()
     * */


}