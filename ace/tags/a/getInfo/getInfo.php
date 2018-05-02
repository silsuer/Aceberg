<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/27
 * Time: 3:50
 */

namespace Ace\tags\a\getInfo;


class getInfo
{

    /* @doc
     * @name: view
     * @require: 空
     * @response: data['php_version','os','upload_max_filesize','memory_limit','author']
     * @description: 用于在前端获取服务器的基本信息
     * @demo: {% set info = ace.tag('a_getInfo') %}
     * @return;
     * @more: http://doc.aceberg.org
     */
    public function view($arr = null)
    {
        $data = [];
        $data['php_version'] = PHP_VERSION;
        $data['os'] = PHP_OS;
        $data['upload_max_filesize'] = get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许上传附件";
        $data['max_execution_time'] = get_cfg_var('max_execution_time') . '秒';
        $data['memory_limit'] = get_cfg_var('memory_limit') ? get_cfg_var('memory_limit') : '无';
        $data['author'] = 'Eince';
//        $data['mysql_version'] = mysql_get_server_info();
        return $data;
    }
}