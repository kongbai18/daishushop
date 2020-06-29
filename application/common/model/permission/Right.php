<?php

namespace app\common\model\permission;

use think\facade\Cache;
use think\Model;

class Right extends Model
{
    protected static function init()
    {
        Right::afterWrite(function () {
            Cache::rm('admin_right_list');
            Cache::rm('admin_right_menu_list');
        });
    }

    public function setModuleAttr($value)
    {
        return strtolower($value);
    }

    public function setControllerAttr($value)
    {
        return strtolower($value);
    }

    public function setMethodAttr($value)
    {
        return strtolower($value);
    }
}
