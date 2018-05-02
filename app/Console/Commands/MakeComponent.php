<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/26
 * Time: 21:36
 */

namespace App\Console\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeComponent extends Command
{

    public function configure()
    {
        $this->setName('make:component')// 命令名
        ->addArgument('componentName', InputArgument::REQUIRED, '请输入组件名 name/componentName'); // 参数1
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('componentName');  // a/if_login
        $nArr = explode('/', $name);
        // 建立描述文件
        $des = [
            "name" => $nArr[1],
            "namespace" => "Ace\\components\\$nArr[0]\\$nArr[1]\\$nArr[1]",
            "description" => "",
            "version" => "1.0"
        ];
        // 在组件文件夹下建立文件夹和类
        $path = root_path() . "/ace/components/$nArr[0]/$nArr[1]";
        if(is_dir($path)){
           $output->writeln("此组件已经存在，不能重复创建！");
           return;
        }
        mkdir($path);  // 建立目录
        // 在目录下建立描述文件
        $file = fopen($path . '/description.json', "w+");
        fwrite($file, json_encode($des));
        fclose($file);

        $content = '
        <?php
        namespace Ace\components\\' . $nArr[0] . '\\' . $nArr[1] . ';

        class '.$nArr[1].'
        {
           public function handle(\swoole_http_request $req, \swoole_http_response $res, $arr = [])
           {
        
           }
        }
        ';
        // 建立php文件
        $file = fopen($path . '/' . $nArr[1] . '.php', "w+");
        fwrite($file,$content);
        fclose($file);

        $output->writeln("success!");
    }
}