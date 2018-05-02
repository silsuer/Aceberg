<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/27
 * Time: 17:13
 */

namespace Ace\plugins\a\ModelManager;


use Ace\components\a\updateTableConstructs\updateTableConstructs;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Illuminate\Database\Capsule\Manager as DB;

// 添加模块的模型
class MakeModuleCommand extends Command
{
    protected function configure()
    {
        $this->setName("make:module")->addArgument('type', null, "操作模块的类型", "create");  // 添加模块命令，交互询问并创建
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $tType = $input->getArgument('type');

        if ($tType == 'create') {
            $modules = DB::table('modules')->get();
            $modules = allToArray($modules);   // 模型列表
            $modulesText = '';
            $modulesArr = [];
            $modulesArr[] = 0;
            foreach ($modules as $v) {
                $modulesText .= $v['id'] . '.' . $v['name'] . "\n";
                $modulesArr[] = $v['id'];  // 添加数组
            }

            $models = DB::table('models')->get();
            $models = allToArray($models);
            $modelsText = '';
            $modelsArr = [];
            foreach ($models as $v) {
                $modelsText .= $v['id'] . '.' . $v['name'] . "\n";
                $modelsArr[] = $v['id'];
            }

            $helper = $this->getHelper('question');
            $question = new Question("输入新的模块名: \n");
            $moduleName = $helper->ask($input, $output, $question);  // 模块名
            $question = new Question("输入模块唯一标识符：\n");
            $targetName = $helper->ask($input, $output, $question);
            $question = new Question("输入模块描述:\n", "");
            $description = $helper->ask($input, $output, $question);
            $question = new ChoiceQuestion("选择所属模型id: \n $modelsText ", $modelsArr);
            $model_id = $helper->ask($input, $output, $question);   // 获取模型id
            $module_id = 0;  // 默认是0
            if (!empty($modulesArr)) {
                $question = new ChoiceQuestion("选择上级模块id: \n $modulesText ", $modulesArr);
                $module_id = $helper->ask($input, $output, $question);
            }

            $status = "使用中";

            $output->writeln("开始添加表字段信息......");
            $config = [];
            $flag = true;
            while ($flag) {
                $question = new Question("输入名称: \n ");
                $name = $helper->ask($input, $output, $question);
                $question = new Question("输入字段名： \n ");
                $dirname = $helper->ask($input, $output, $question);

                $question = new Question("输入字段注释: \n");
                $comment = $helper->ask($input, $output, $question);
                $question = new Question("输入字段类型:(integer|string|text等) \n", "string");
                $type = $helper->ask($input, $output, $question); // 获取类型
                $question = new Question("输入显示类型:(input|password|testarea等)", "input");
                $view = $helper->ask($input, $output, $question);
                $question = new ChoiceQuestion("是否显示在列表页中? \n", ['是', '否'], 1);
                $show = $helper->ask($input, $output, $question);

                if ($show == '是') {
                    $show = 1;
                } else {
                    $show = 0;
                }

                $data = [
                    'name' => $name,
                    'dir' => $dirname,
                    'comment' => $comment,
                    'type' => $type,
                    'view' => $view,
                    'show' => $show,
                ];
                $config[$dirname] = $data;
                $output->writeln(" $dirname 字段添加完毕........");
                $question = new ConfirmationQuestion("是否继续添加？", true);
                $flag = $helper->ask($input, $output, $question);
            }

            // 数据添加完毕，准备插入
            $insert = [
                'name' => $moduleName,
                'target' => $targetName,
                'description' => $description,
                'model_id' => $model_id,
                'module_id' => $module_id,
                'status' => $status,
                'config' => json_encode($config)
            ];

            $a = new updateTableConstructs();
            $a->handle(null, null, $insert);
            DB::table('modules')->insert($insert);
            $output->writeln("模块添加成功！\n");
        } elseif ($tType == 'refresh') {
            // 将删除模块表对应的所有表，然后根据模块表重建表
            $res = DB::table('modules')->get();
            $res = allToArray($res);
            foreach ($res as $v) {
                // 删除所有表
                DB::schema()->dropIfExists($v['target']);
            }
            $a = new updateTableConstructs();
            foreach ($res as $v) {
                $a->handle(null, null, $v);
            }
        }


    }


}