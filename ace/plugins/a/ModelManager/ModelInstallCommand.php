<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/27
 * Time: 16:10
 */

namespace Ace\plugins\a\ModelManager;

// 模型安装命令
use S\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelInstallCommand extends Command
{
    protected function configure()
    {
       $this->setName('require:model')->addArgument('modelName',InputArgument::REQUIRED,'模型名称： a/ArticalContent');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('modelName');
        $arr = explode('/', $name);
        $name = join('_', $arr);
        $this->installModel($arr,$name,$output);
    }

    public function installModel($arr, $name, $output)
    {
        Template::organizeTree();  // 先组织这些树，然后去插件目录下判断
//        print_r(Template::$modelsTree);die();
//        print_r(Template::$modelsTree);   存在目录和命名空间
        if (array_key_exists($name, Template::$modelsTree)) {
            if (array_key_exists('namespace', Template::$modelsTree[$name])) {
                $model = Template::$modelsTree[$name]; // 获取模型信息
//                echo ace_path() . '/' . $model['path'] . '/' . $arr[1] . '.php';
                if (file_exists(ace_path() . '/' . $model['path'] . '/' . $arr[1] . '.php')) {
                    // TODO 检测依赖，安装依赖库

                    $model = new $model['namespace'];
                    $model->install();  // 执行install方法

                    $output->writeln("\n" . $name .'安装成功！');
                    return;
                } else {
                    $output->writeln("\n" . $name . '目录结构缺失，请检查是否存在安装文件以及描述文件description.json');
                }
            } else {
                $output->writeln("\n" . $name . '目录结构缺失，请检查是否存在安装文件以及描述文件description.json');
            }

        } else {
            $output->writeln("\n" . $name . '不存在该模型，正在扫描官方库进行安装......');
            // TODO 连接官方仓库，获取数据，并放置到对应目录上
            // TODO 获取完成
            $output->writeln("\n" . $name . '下载完成正在安装......');
            $this->installModel($arr, $name,$output);
        }
        return;
    }

}