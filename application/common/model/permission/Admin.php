<?php

namespace app\common\model\permission;

use app\common\lib\IAuth;
use think\Model;

class Admin extends Model
{
    protected $autoWriteTimestamp = true;
    protected $field = true;
    protected $hidden = ['password'];

    public function role(){
        return $this->hasMany('AdminRole','admin_id','id');
    }

    public function setPasswordAttr($value)
    {
        return IAuth::setPassword($value);
    }

    public function getList($data)
    {
        $where = [];

        if(isset($data['name']) && $data['name']){
            $where[] = ['a.admin_name','like','%'.trim($data['name']).'%'];
        }

        if (isset($data['role_id']) && is_numeric($data['role_id'])){
            $where[] = ['b.role_id','eq',$data['role_id']];
        }

        if(isset($data['size']) && is_numeric($data['size'])){
            $size = (int)$data['size'];
        }else{
            $size = 10;
        }


        $list = $this->alias('a')->field('a.*')
            ->leftJoin('admin_role b','a.id = b.admin_id')
            ->where($where)
            ->group('a.id')
            ->order('a.id asc')
            ->paginate($size,false,['query'=>$data]);

        return $list;
    }
}
