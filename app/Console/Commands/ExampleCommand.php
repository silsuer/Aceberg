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

class ExampleCommand extends Command
{

    public function configure()
    {
        $this->setName('commandName') // 命令名
             ->addArgument('arg1',InputArgument::REQUIRED,'参数提示')  // 参数1
             ->addArgument('arg2');  // 参数2
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
       $arg1 = $input->getArgument('arg1');
       $arg2 = $input->getArgument('arg2');
    }
}