<?php declare(strict_types = 1);

namespace AceMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502173924 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // 建立一张锚点表，有id name handle三列
        if(!DB::schema()->hasTable('anchors')){
            DB::schema()->create('anchors',function (Blueprint $table){
               $table->increments('id');
               $table->string('name')->comment('锚点名称');
               $table->text('handle')->comment('序列化后的锚点要执行的函数的数组');
            });
        }
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
