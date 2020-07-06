<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/6
 * Time: 13:45
 */

namespace app\common\model\shop;


use think\Model;

class GoodsSpec extends Model
{
    protected $autoWriteTimestamp = true;
    protected $field = true;

    /**
     * 根据规格名称获取规格id
     * @param GoodsSpecModel $goodsSpecModel
     * @param $specName
     * @param $typeId
     * @return bool|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *User: ligo
     */
    public function getSpecInfoByName($specName, $typeId)
    {
        $info = $this->where([
            ['spec_name','eq',$specName],
            ['type_id','eq',$typeId],
        ])->find();

        if($info){
            return $info;
        }

        return false;
    }
}