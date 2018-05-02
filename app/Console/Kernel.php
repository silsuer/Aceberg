<?php
/**
 * Created by PhpStorm.
 * User: liuho
 * Date: 2018/4/26
 * Time: 21:15
 */

namespace App\Console;


// 内核
use Ace\plugins\a\ModelManager\AddRelationCommand;
use Ace\plugins\a\ModelManager\MakeModuleCommand;
use Ace\plugins\a\ModelManager\ModelInstallCommand;
use App\Console\Commands\DocCommand;
use App\Console\Commands\InstallPlugin;
use App\Console\Commands\MakeComponent;
use App\Console\Commands\MakeTag;
use App\Console\Commands\TestCommand;
use App\Console\Commands\TestCommand2;

class Kernel
{
   public static $commands = [
//     ExampleCommand::class              示例命令
      MakeComponent::class,
       TestCommand::class,
       InstallPlugin::class,
       ModelInstallCommand::class,
       MakeModuleCommand::class,
       DocCommand::class,
       AddRelationCommand::class,
       MakeTag::class
   ];
}