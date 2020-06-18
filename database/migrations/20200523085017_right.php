<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Right extends Migrator
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
        $table = $this->table('right',['engine'=>'InnoDB','default'=>'权限表']);
        $table->addColumn('name','string',['limit'=>30,'default'=>'','comment'=>'权限名称'])
            ->addColumn('module','string',['limit'=>255,'default'=>'','comment'=>'模型名称'])
            ->addColumn('controller','string',['limit'=>255,'default'=>'','comment'=>'模型名称'])
            ->addColumn('method','string',['limit'=>255,'default'=>'','comment'=>'模型名称'])
            ->addColumn('icon','string',['limit'=>255,'default'=>'','comment'=>'图标'])
            ->addColumn('parent_id','integer',['limit'=>11,'default'=>0,'comment'=>'上级id'])
            ->addColumn('sort','integer',['limit'=>11,'default'=>100,'comment'=>'排序'])
            ->addColumn('is_menu','integer',['limit'=>4,'default'=>1,'comment'=>'是否作为菜单'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('right');
    }
}
