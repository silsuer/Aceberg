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

class MakeTag extends Command
{

    public function configure()
    {
        $this->setName('make:tag')// 命令名
        ->addArgument('tagName', InputArgument::REQUIRED, '要添加的标签名')// 参数1
        ->setDescription("添加自定义的标签，形如： php sword make:tag tagName");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // 根据标签，建立目录和文件，并写入默认文件
        $tagName = $input->getArgument('tagName'); // 获取到要添加的标签
        $tagArr = explode('/', $tagName);
        $author = $tagArr[0];
        $name = $tagArr[1];   // a/getModelsList
        $des = [
            "name" => $name,
            "namespace" => "Ace\\tags\\$author\\$name\\$name",
            "description" => "",
            "version" => "1.0"
        ];

        // 在标记文件夹下建立文件夹和类
        $path = root_path() . "/ace/tags/$author/$name";
        if (is_dir($path)) {
            $output->writeln("<error>此标记已经存在，不能重复创建！</error>");
            return;
        }

        mkdir($path);  // 建立目录
        // 在目录下建立描述文件
        $file = fopen($path . '/description.json', "w+");
        fwrite($file, json_encode($des));
        fclose($file);

        $content = '
        <?php
        namespace Ace\tags\\' . $author . '\\' . $name . ';

        class ' . $name . '
        {
          /* @doc
           * @name: view
           * @require: 空
           * @response: 
           * @description: 
           * @demo: {% set info = ace.tag(\'' . $author . '_' . $name . '\') %}
           * @return;
           * @more: http://doc.aceberg.org
           */
           public function view($arr = [])
           {
        
           }
        }
        ';
        $file = fopen($path . '/' . $name . '.php', "w+");
        fwrite($file, $content);
        fclose($file);
        $output->writeln("<info>success!</info>");
    }
}