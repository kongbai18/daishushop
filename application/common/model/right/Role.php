<?php

namespace app\common\model\right;

use think\Model;

class Role extends Model
{
    //
    public function right(){
        return $this->hasMany('RoleRight','id','role_id');
    }
}
