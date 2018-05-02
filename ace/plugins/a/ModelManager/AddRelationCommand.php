<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/29
 * Time: 20:18
 */

namespace Ace\plugins\a\ModelManager;


use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Database\Capsule\Manager as DB;
use Symfony\Component\Console\Question\ChoiceQuestion;

// 为模块之间添加关联的选项
class AddRelationCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:relation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // 添加关联，一对一，一对多无需添加表，如果是多对多，则新建一张关联表，表名是 表1_表2_relations

        // 请选择要关联的模块
        // 请选择被关联的模块
        // 请选择关联方式

        $modules = DB::table('modules')->get();
        $modules = allToArray($modules);
        $modulesArr = [];
        foreach ($modules as $v) {
            $modulesArr[] = $v['name'] . ':' . $v['target'];
        }

        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion("请选择要关联的模块： \n", $modulesArr);
        $n = $helper->ask($input, $output, $question);

        $nName = explode(':', $n);
        // 第二个就是要关联的表名
        $tableName = $nName[1];

        $colsList = DB::schema()->getColumnListing($tableName);

        $question = new ChoiceQuestion("请选择要关联的列： \n", $colsList);
        $primary_key = $helper->ask($input, $output, $question);

        // 也可以自关联
        $question = new ChoiceQuestion("请选择被关联的模块： \n", $modulesArr);
        $n = $helper->ask($input, $output, $question);
        $nName = explode(':', $n);
        $relatedName = $nName[1];

        $colsList = DB::schema()->getColumnListing($relatedName);
        $question = new ChoiceQuestion("请选择被关联的列： \n", $colsList);
        $foreign_key = $helper->ask($input, $output, $question);

        $type = ['一对一', '一对多', '多对多'];

        $question = new ChoiceQuestion("请选择建立关联的方式： \n", $type);
        $tType = $helper->ask($input, $output, $question);
        $relationType = '';

        switch ($tType) {
            case '一对一':
                $relationType = 'OneToOne';
                break;
            case '一对多':
                $relationType = 'OneToMany';
                break;
            case '多对多':
                $relationType = 'ManyToMany';
                // 建立一张关联表
                DB::schema()->create($tableName . '_' . $relatedName . '_' . 'relations', function (Blueprint $table) use ($tableName, $relatedName, $primary_key, $foreign_key) {
                    $table->increments('id');
                    $table->string($tableName . '_' . $primary_key)->comment($tableName . '表的关联主键');
                    $table->string($relatedName . '_' . $foreign_key)->comment($relatedName . '表的关联外键');
                });
                break;
            default:
                $output->writeln("<error>无效的关联关系!</error>");
                break;
        }

        // 将关联关系入库
        $insert = [
            'table' => $tableName,
            'related' => $relatedName,
            'primary_key' => $primary_key,
            'foreign_key' => $foreign_key,
            'relation' => $relationType
        ];
        DB::table('relations')->insert($insert);
        $output->writeln("<info>成功添加关联！</info>");
    }
}