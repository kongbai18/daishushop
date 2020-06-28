<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/28
 * Time: 15:43
 */

namespace app\common\behavior;


use think\facade\Session;
use traits\controller\Jump;

class AdminAuth
{
    use Jump;

    public function run(){
        $adminId = Session::get('admin_login_session');
        if(!$adminId){
            return $this->error('暂未登录','login/login');
        }
    }
}