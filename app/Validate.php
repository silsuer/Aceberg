<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/5/5
 * Time: 11:15
 */

namespace App;


// 针对传入的数据进行验证，并返回验证结果
class Validate
{
    // 根据验证规则写函数名，传入验证数据即可
    public static function validate($role, $data)
    {
        $arr = explode(':', $role);

        if (count($arr)==1) $arr[1] = [];
        if (method_exists(self::class, $arr[0])) {
            $a = self::{$arr[0]}($arr[1], $data);
            return $a;
        } else {
            return '无效的验证规则';
        }
    }

    // 验证规则是0或1,或者yes no true和false才会通过
    public static function accepted($role, $data)
    {
        if ($data == 0 || $data == 1 || $data == '0' || $data == '1' || $data == 'yes' || $data == 'no' || $data == 'Y' || $data == 'N' || $data == true || $data == false) {
            return true;
        } else {
            return '格式不正确';
        }
    }

    public static function active_url($role, $data)
    {
        return checkdnsrr($data);
    }

    // 返回时间是否在指定时间之后
    public static function after($role, $data)
    {
//        $role 应该是一个日期格式的数据
        $role_time = strtotime($role);
        $data_time = strtotime($data);
        if ($data_time > $role_time) {
            return true;
        } else {
            return '日期时间不正确';
        }
    }

    // 字段仅全数为字母字串时通过验证。
    public static function alpha($role, $data)
    {
        if (ctype_alpha($data)) {
            return true;
        } else {
            return '必须全部为字母';
        }
    }

    // 字段值仅允许字母、数字、破折号（-）以及底线（_）
    public static function alpha_dash($role, $data)
    {

    }

     //字段值仅允许字母、数字
    public static function alpha_num($role, $data)
    {

    }

    public static function required($role,$data){
        if($data==''||is_null($data)){
            return '为必填项';
        }else{
            return true;
        }

    }

}