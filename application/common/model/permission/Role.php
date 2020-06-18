<?php

namespace app\common\model\permission;

use think\Model;

class Role extends Model
{
    //
    public function right(){
        return $this->hasMany('RoleRight','id','role_id');
    }
}
