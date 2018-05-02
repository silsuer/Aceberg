<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/26
 * Time: 21:36
 */

namespace App\Console\Commands;


use S\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallPlugin extends Command
{

    public function configure()
    {
        $this->setName('require:plugin')// 命令名
        ->addArgument('pluginName', InputArgument::REQUIRED, '插件名'); // 参数1
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // 拿到插件名，先去插件文件夹下判断插件是否存在，不存在，去远程下载，存在，new出来，执行install函数
        // a/ModelManager
        $name = $input->getArgument('pluginName');
        $arr = explode('/', $name);
        $name = join('_', $arr);

        $this->installPlugin($arr, $name, $output);

    }

    public function installPlugin($arr, $name, $output)
    {
        Template::organizeTree();  // 先组织这些树，然后去插件目录下判断
//        print_r(Template::$pluginsTree);   //存在目录和命名空间
        if (array_key_exists($name, Template::$pluginsTree)) {
            if (array_key_exists('namespace', Template::$pluginsTree[$name])) {
                $plugin = Template::$pluginsTree[$name]; // 获取插件信息
                // 插件存在，判断插件目录和描述文件
//                echo ace_path() . '/' . $plugin['path'] . '/' . $arr[1] . '.php';
//                echo ace_path() . '/' . $plugin['path'] . '/' . $arr[1] . '.php' . "\n";
                if (file_exists(ace_path() . '/' . $plugin['path'] . '/' . $arr[1] . '.php')) {
                    // TODO 检测依赖，安装依赖库

                    $plugin = new $plugin['namespace'];
                    $plugin->install();  // 执行install方法

                    $output->writeln("\n" . $name .'安装成功！');
                    return;
                } else {
                    $output->writeln("\n" . $name . '目录结构缺失，请检查是否存在安装文件以及描述文件description.json是否存在namespace');
                }
            } else {
                $output->writeln("\n" . $name . '目录结构缺失，请检查是否存在安装文件以及描述文件description.json是否存在namespace');
            }

        } else {
            $output->writeln("\n" . $name . '不存在该插件，正在扫描官方库进行安装......');
            // TODO 连接官方仓库，获取数据，并放置到对应目录上
            // TODO 获取完成
            $output->writeln("\n" . $name . '下载完成正在安装......');
            $this->installPlugin($arr, $name,$output);
        }
        return;
    }

}