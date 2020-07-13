<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/6
 * Time: 13:45
 */

namespace app\common\model\shop;


use think\Model;

class GoodsSpecValue extends Model
{
    protected $autoWriteTimestamp = true;
    protected $field = true;

    /**
     * 根据规格值标记获取全部信息
     * @param GoodsSpecValueModel $goodsSpecValueModel
     * @param $specValueAlt
     * @param $specId
     * @return bool|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *User: ligo
     */
    public function getSpecValueInfoByName($specValue, $specId)
    {
        $info = $this->where([
            ['spec_value','eq',$specValue],
            ['spec_id','eq',$specId],
        ])->find();

        if($info){
            return $info;
        }

        return false;
    }
}