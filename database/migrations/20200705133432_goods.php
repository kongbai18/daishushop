<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Goods extends Migrator
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
        $table = $this->table('goods',['engine'=>'InnoDB','default'=>'商品表']);
        $table->addColumn('goods_name','string',['limit'=>255,'default'=>'','comment'=>'商品名称'])
            ->addColumn('snumber','string',['limit'=>255,'default'=>'','comment'=>'商品唯一标识'])
            ->addColumn('img_url','string',['limit'=>255,'default'=>'','comment'=>'商品首图'])
            ->addColumn('content','text',['comment'=>'详情'])
            ->addColumn('sort_id','integer',['limit'=>11,'default'=>100,'comment'=>'排序'])
            ->addColumn('status','integer',['limit'=>4,'default'=>1,'comment'=>'状态'])
            ->addColumn('is_delete','integer',['limit'=>4,'default'=>2,'comment'=>'是否删除'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('goods');
    }
}
