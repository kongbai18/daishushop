<?php

namespace app\common\model\permission;

use think\facade\Cache;
use think\Model;

class Role extends Model
{
    protected static function init()
    {
        Role::afterWrite(function () {
            Cache::rm('admin_role_list');
        });
    }

    public function right(){
        return $this->hasMany('RoleRight','role_id','id');
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
            ->where($where)
            ->with('right')
            ->group('a.id')
            ->order('a.id desc')
            ->paginate($size,false,['query'=>$data]);

        return $list;
    }
}
