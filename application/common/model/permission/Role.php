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
            $where[] = ['name','like','%'.trim($data['name']).'%'];
        }

        if(isset($data['size']) && is_numeric($data['size'])){
            $size = (int)$data['size'];
        }else{
            $size = 10;
        }

        $list = $this->field('*')
            ->where($where)
            ->with('right')
            ->group('id')
            ->order('id asc')
            ->paginate($size,false,['query'=>$data]);

        return $list;
    }
}
