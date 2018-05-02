<?php declare(strict_types = 1);

namespace AceMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426174008 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // 建立后台用户表
       DB::schema()->create('admin',function (Blueprint $table){
           $table->increments('id');
           $table->string('name')->comment('用户名');  // 用户名
           $table->string('password')->comment('密码');
           $table->text('avatar')->nullable()->comment('头像');
       }) ;

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
