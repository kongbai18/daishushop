<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Products extends Migrator
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
        $table = $this->table('products',['engine'=>'InnoDB','default'=>'产品表']);
        $table->addColumn('goods_id','integer',['limit'=>11,'default'=>0,'comment'=>'商品id'])
            ->addColumn('sku','string',['limit'=>255,'default'=>'','comment'=>'产品唯一标识'])
            ->addColumn('goods_price','decimal',['limit'=>10,2,'default'=>0.00,'comment'=>'产品价格'])
            ->addColumn('line_price','decimal',['limit'=>10,2,'default'=>0.00,'comment'=>'产品划线价格'])
            ->addColumn('stock_num','integer',['limit'=>11,'default'=>0,'comment'=>'库存'])
            ->addColumn('occupy_stock','integer',['limit'=>11,'default'=>0,'comment'=>'占用库存'])
            ->addColumn('goods_weight','double',['default'=>0,'comment'=>'产品重量'])
            ->addColumn('status','integer',['limit'=>4,'default'=>1,'comment'=>'状态'])
            ->addColumn('img_url','string',['limit'=>255,'default'=>'','comment'=>'对应产品图'])
            ->addColumn('create_time','integer',['limit'=>11,'default'=>0,'comment'=>'创建时间'])
            ->addColumn('update_time','integer',['limit'=>11,'default'=>0,'comment'=>'更新时间'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('products');
    }
}
