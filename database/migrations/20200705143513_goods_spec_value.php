<?php

use think\migration\Migrator;
use think\migration\db\Column;

class GoodsSpecValue extends Migrator
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
        $table = $this->table('goods_spec_value',['engine'=>'InnoDB','default'=>'产品规格值表']);
        $table->addColumn('spec_value','string',['limit'=>255,'default'=>'','comment'=>'规格值'])
            ->addColumn('spec_value_alt','string',['limit'=>255,'default'=>'','comment'=>'规格值标记词'])
            ->addColumn('spec_id','integer',['limit'=>11,'default'=>0,'comment'=>'规格id'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('goods_spec_valueGIT');
    }
}
