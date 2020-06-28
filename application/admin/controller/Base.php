<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/28
 * Time: 16:25
 */

namespace app\admin\controller;


use think\App;
use think\Controller;
use think\facade\Session;


class Base extends Controller
{
    protected $adminId = null;

    public function initialize()
    {
        $result = $this->checkLogin();
        if($result === false){
            return $this->error('暂未登录','login/login');
        }
    }

    public function checkLogin(){
        $adminId = Session::get('admin_login_session');
        if(!$adminId){
            return false;
        }else{
            $this->adminId = $adminId;
        }
    }
}