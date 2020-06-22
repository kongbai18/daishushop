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
        });
    }
}
