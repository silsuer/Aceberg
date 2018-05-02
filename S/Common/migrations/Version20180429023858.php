<?php declare(strict_types = 1);

namespace AceMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180429023858 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

        // 建立一张关联关系表
        DB::schema()->create('relations',function (Blueprint $table){
            $table->increments('id');
            $table->string('table')->comment('要添加关联的表');
            $table->string('related')->comment('被关联的表');
            $table->string('primary_key')->comment('关联表的主键');
            $table->string('foreign_key')->comment('被关联表的外键');
            $table->string('relation')->comment('关联关系，一对一，一对多，多对多等');
        });

        // 添加关联，一对一，一对多无需添加表，如果是多对多，则新建一张关联表，表名是 表1_表2_relations

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
