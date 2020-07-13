<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/6
 * Time: 17:06
 */

namespace app\common\logic\shop;

use app\common\model\shop\GoodsSpec as GoodsSpecModel;
use app\common\model\shop\GoodsSpecValue as GoodsSpecValueModel;
use think\Db;

class GoodsSpec
{
    /**
     * 同步添加规格和规格值
     * @param $specData
     * @param $specValueData
     * @return array
     *User: ligo
     */
    public function saveSpecAndSpecValue($specData, $specValueData)
    {
        Db::startTrans();
        try{
            $goodsSpecModel = new GoodsSpecModel();
            $spec = $goodsSpecModel->getSpecInfoByName($specData['spec_name'], $specData['type_id']);
            if($spec !== false){
                $specId = $spec['id'];
            }else{
                $goodsSpecModel->save($specData);
                $specId = $goodsSpecModel->id;
            }

            $goodsSpecValueModel = new GoodsSpecValueModel();
            $goodsSpecValue = [];
            foreach ($specValueData as $v){
                $specValue = $goodsSpecValueModel->getSpecValueInfoByName($v['spec_value'], $specId);
                if($specValue === false){
                    $v['spec_id'] = $specId;
                    $goodsSpecValue[] = $v;
                }
            }
            if($goodsSpecValue){
                $goodsSpecValueModel->saveAll($goodsSpecValue);
            }

        }catch (\Exception $e){
            Db::rollback();
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
            ];
        }

        Db::commit();
        return [
            'status' => true,
            'msg'    => '添加成功',
        ];
    }

    /**
     * 添加规格
     * @param $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *User: ligo
     */
    public function saveSpec($data)
    {
        //根据规格名获取信息；存在则返回
        $goodsSpecModel = new GoodsSpecModel();
        $spec = $goodsSpecModel->getSpecInfoByName($data['spec_name'], $data['type_id']);
        if($spec !== false){
            return [
                'status' => true,
                'msg'    => '',
                'data'   => $spec,
            ];
        }

        //信息不存在；进行信息存储
        try{
            $goodsSpecModel->save($data);
            $data['id'] = $goodsSpecModel->id;
        }catch (\Exception $e){
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
                'data'   => [],
            ];
        }

        return [
            'status' => true,
            'msg'    => '',
            'data'   => $data,
        ];
    }

    /**
     * 添加规格值
     * @param $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *User: ligo
     */
    public function saveSpecValue($data)
    {
        //根据规格值标记获取信息；存在则返回
        $goodsSpecValueModel = new GoodsSpecValueModel();
        $specValue = $goodsSpecValueModel->getSpecValueInfoByName($data['spec_value'], $data['spec_id']);
        if($specValue !== false){
            return [
                'status' => true,
                'msg'    => '',
                'data'   => $specValue,
            ];
        }

        //信息不存在；进行信息存储
        try{
            $goodsSpecValueModel->save($data);
            $data['id'] = $goodsSpecValueModel->id;
        }catch (\Exception $e){
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
                'data'   => [],
            ];
        }

        return [
            'status' => true,
            'msg'    => '',
            'data'   => $data,
        ];
    }
}