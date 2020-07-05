<?php

use think\migration\Migrator;
use think\migration\db\Column;

class GoodsSpec extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('goods_spec',['engine'=>'InnoDB','default'=>'产品规格表']);
        $table->addColumn('spec_name','string',['limit'=>255,'default'=>'','comment'=>'规格名称'])
            ->addColumn('type','integer',['limit'=>4,'default'=>1,'comment'=>'规格；类型'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('goods_spec');
    }
}
