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

class DocCommand extends Command
{
    // 生成配置配置表格
    public function configure()
    {
        $this->setName('doc')// 命令名
        ->addArgument('type', null, '文档命令类型(名称/list)', 'all');  // 如果是list，列出所有列表，如果是名称，打印出对应的所有文档，如果是all，开启一个http服务器，加入了doc控制器
//             ->addArgument('arg2');  // 参数2
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // a/admin_login   list  all
        $type = $input->getArgument('type');

        switch ($type) {
            case 'list':
                $this->listDoc($output);
                break;
            case 'all':
                $this->allDoc($output);
                break;
            default:
                $this->specDoc($output, $type);
                break;
        }
    }


    // 列出所有列表
    private function listDoc(OutputInterface $output)
    {
        Template::organizeTree();// 初始化结构
        // 将所有数据按照一定格式打印出来
        if (!empty(Template::$modelsTree)) {
            $this->outputList($output, 'model');
        }
        if (!empty(Template::$pluginsTree)) {
            $this->outputList($output, 'plugin');
        }
        if (!empty(Template::$componentsTree)) {
            $this->outputList($output, 'component');
        }
        if (!empty(Template::$tagsTree)) {
            $this->outputList($output, 'tag');
        }
        if (!empty(Template::$macroTree)) {
            $this->outputList($output, 'macro');
        }
        if (!empty(Template::$themesTree)) {
            $this->outputList($output, 'theme');
        }

    }

    private function outputList(OutputInterface $output, $treeName)
    {
        $nName = "";
        switch ($treeName) {
            case 'model':
                $treeName = 'modelsTree';
                $nName = "模型";
                break;
            case 'plugin':
                $treeName = 'pluginsTree';
                $nName = "插件";
                break;
            case 'component':
                $treeName = 'componentsTree';
                $nName = "组件";
                break;
            case 'tag':
                $treeName = 'tagsTree';
                $nName = "标记";
                break;
            case 'macro':
                $treeName = 'macroTree';
                $nName = "宏";
                break;
            case 'theme':
                $treeName = 'themesTree';
                $nName = "主题";
            default:
                break;
        }

        $output->writeln("<question> $nName 列表:</question>");

        // 输出
        foreach (Template::$$treeName as $k => $v) {
            // a/ArticleContent
            $nArr = explode('_', $k);
            $authorName = $nArr[0];
            unset($nArr[0]);
            $modelName = join('_', $nArr);  // admin_login
            $name = $authorName . '/' . $modelName;
            $descriptionPath = ace_path() . '/' . $v['path'] . '/description.json';
            if (!file_exists($descriptionPath)) {
                $output->writeln(" $name 不存在描述文件!");
                return;
            }
            $content = json_decode(file_get_contents($descriptionPath), true);  // 获取描述数组
            $des = '';
            if (array_key_exists('description', $content)) $des = $content['description'];
            $output->writeln("<info>   $name \t $des</info>");
        }
        $output->writeln('');
    }

    // 开启一个http服务器，加入一个控制器
    private function allDoc(OutputInterface $output)
    {
        require root_path() . '/Server.php';
        $a = new \Server();
        \Server::$routesList['/doc'] = routeInit()->setMethod('get')->setTarget("App\DocController@showDoc");
        \Server::$info = "\n 已添加文档路由...... \n 现在可以使用 域名/doc 的形式访问项目文档了！";
        $a->start();
    }

    // 指定的名字 a/admin_login
    private function specDoc(OutputInterface $output, $name)
    {
        $rName = $name;  // 先保存一份
        // 先判断传入的名字是否合格
        $nName = explode('/', $name);
        if (count($nName) != 2) {
            $output->writeln("<error>输入参数的格式不正确！</error>");
        }
        $name = join('_', $nName);
        Template::organizeTree();  // 组织树
        $flag = true; // 判断是否找到了数据
        // 判断哪个位置有这个名字
        if (array_key_exists($name, Template::$modelsTree)) {
            $output->writeln("<question>在模型列表中找到:</question>");
            // 判断模型列表
            $flag = false;
            $this->printSpecDoc($output, $rName, 'themes');
        }
        if (array_key_exists($name, Template::$pluginsTree)) {
            $output->writeln("<question>在插件列表中找到:</question>");
            $flag = false;
            $this->printSpecDoc($output, $rName, 'plugins');
        }
        if (array_key_exists($name, Template::$macroTree)) {
            $output->writeln("<question>在宏列表中找到:</question>");
            $flag = false;
            $this->printSpecDoc($output, $rName, 'macro');
        }
        if (array_key_exists($name, Template::$componentsTree)) {
            $output->writeln("<question>在组件列表中找到:</question>");
            $flag = false;
            $this->printSpecDoc($output, $rName, 'components');
        }
        if (array_key_exists($name, Template::$tagsTree)) {
            $output->writeln("<question>在标记列表中找到:</question>");
            $flag = false;
            $this->printSpecDoc($output, $rName, 'tags');
        }
        // 在xx列表中找到指定数据:
        // @require:
        // @response: ...
        if ($flag) {
            $output->writeln("<error>未找到 $name 数据</error>");
        }
    }

    // type是主题插件等等，name是 a/admin_login之类的
    private function printSpecDoc(OutputInterface $output, $name, $type)
    {
        // 找到对应的php文件，根据正则解析数据
        $path = ace_path() . '/' . $type . '/' . $name;
        $nName = explode('/', $name);
        unset($nName[0]);  // 去掉第一个
        $name = join('_', $nName);
        $filePath = $path . '/' . $name . '.php';
        $content = "";
        if(file_exists($filePath)){
            $content = file_get_contents($filePath);
        }else{
            $output->writeln("<error>查找 $name 文件失败！</error>");
            return;
        }

        // 正则匹配
//        print_r($content);
//        $role = "/(\\/\*\s+\@doc\s+).*\*\//";
        $role = "/(\/\*)\s+(@doc)((.*\n)*?.*?)?(\*\/)/s";

        preg_match_all($role,$content,$mattches);
        foreach ($mattches[0] as $v){ // 打印每一个匹配
            // 除掉 /*@doc ... */
            $v = mb_substr($v,strpos($v,'doc')+3,strpos($v,'*/'));
            $output->writeln("<comment>$name :</comment>");
            foreach (explode("\n",$v) as $vv ){
                if(trim($vv)=='*/') continue;
                $output->writeln("<info> $vv </info>");
            }
            $output->writeln('');
        }
    }
}