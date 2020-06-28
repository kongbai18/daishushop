<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Admin extends Migrator
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
        $table = $this->table('admin',['engine'=>'InnoDB','default'=>'管理员表']);
        $table->addColumn('admin_name','string',['limit'=>30,'default'=>'','comment'=>'用户名'])
            ->addColumn('password','string',['limit'=>32,'comment'=>'密码'])
            ->addColumn('email','string',['default'=>'','comment'=>'邮箱'])
            ->addColumn('avatar','string',['limit'=>255,'default'=>'','comment'=>'头像'])
            ->addColumn('last_ip','string',['limit'=>30,'default'=>'','comment'=>'最后登录ip'])
            ->addColumn('last_time','integer',['limit'=>11,'default'=>0,'comment'=>'最后登录时间'])
            ->addColumn('status','integer',['limit'=>1,'default'=>1,'comment'=>'状态'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();

        $table = $this->table('admin_role',['engine'=>'InnoDB','default'=>'用户角色关联表']);
        $table->addColumn('role_id','integer',['limit'=>11,'default'=>0,'comment'=>'角色id'])
            ->addColumn('admin_id','integer',['limit'=>11,'default'=>0,'comment'=>'角色id'])
            ->save();

    }

    public function down()
    {
        $this->dropTable('admin');
        $this->dropTable('admin_role');
    }
}
