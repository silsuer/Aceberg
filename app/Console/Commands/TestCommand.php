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
use Illuminate\Database\Capsule\Manager as DB;

class TestCommand extends Command
{

    public function configure()
    {
        $this->setName('test');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $a = DB::schema()->hasTable('admin');
        print_r($a);
        $output->writeln($a);
    }
}