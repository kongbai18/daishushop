<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Role extends Migrator
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
        $table = $this->table('role',['engine'=>'InnoDB','default'=>'角色表']);
        $table->addColumn('name','string',['limit'=>30,'default'=>'','comment'=>'角色名称'])
            ->addColumn('desc','string',['limit'=>255,'default'=>'','comment'=>'角色描述'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();

        $table = $this->table('role_right',['engine'=>'InnoDB','default'=>'角色权限关联表']);
        $table->addColumn('role_id','integer',['limit'=>11,'default'=>0,'comment'=>'角色id'])
            ->addColumn('right_id','integer',['limit'=>11,'default'=>0,'comment'=>'权限id'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('role');
        $this->dropTable('role_right');
    }
}
