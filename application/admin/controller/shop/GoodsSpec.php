<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/13
 * Time: 14:19
 */

namespace app\admin\controller\shop;


use app\admin\controller\Base;
use app\common\logic\shop\GoodsSpec as GoodsSpecLogic;

class GoodsSpec extends Base
{
    public function createGoodsSpecAndSpecValue()
    {
        $this->assign('specType',config('shop.spec_type'));
        return $this->fetch();
    }

    public function saveGoodsSpecAndSpecValue()
    {
       $data = $this->request->param();
       //数据验证
       $validateResult = $this->validate($data,'app\common\validate\shop\GoodsSpec.save');
       if($validateResult !== true){
           return $this->result([],102,$validateResult);
       }

       if(!isset($data['spec_value_list']) || !is_array($data['spec_value_list'])){
           return $this->result([],102,'规格值数据格式出错');
       }

       $validateResult = $this->validate($data,'app\common\validate\shop\GoodsSpecValue.save');
       if($validateResult !== true){
           return $this->result([],102,$validateResult);
       }

       $goodsSpecLogic = new GoodsSpecLogic();
       $result = $goodsSpecLogic->saveSpecAndSpecValue($data, $data['spec_value_list']);
       if($result['status']){
           return $this->result([],100,$result['msg']);
       }

       return $this->result([],105,$result['msg']);
    }
}