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
use think\facade\Env;
use think\facade\Session;
use app\common\model\permission\Right as RightModel;
use app\common\model\permission\AdminRole as AdminRoleModel;
use app\common\model\permission\RoleRight as RoleRightModel;


class Base extends Controller
{
    protected $adminId = null;

    public function initialize()
    {
        $result = $this->checkLogin();
        if($result === false){
            return $this->redirect('login/login');
        }

        $this->checkPermission();
    }

    public function checkLogin()
    {
        $adminId = Session::get('admin_login_session');
        if(!$adminId){
            return false;
        }else{
            $this->adminId = $adminId;
        }
    }

    public function checkPermission()
    {
        //1号管理员拥有超级权限
        if($this->adminId == 1){
            return true;
        }

        //拥有超级管理员角色；拥有超级权限
        $adminRole = AdminRoleModel::field('role_id')->where([
            ['admin_id','eq',$this->adminId],
        ])->select()->toArray();

        if(in_array(1,array_column($adminRole,'role_id'))){
            return true;
        }

        $module = $this->request->module();
        $controller = $this->request->controller();
        $method = $this->request->action();


        $rightInfo = RightModel::where([
            ['module','eq',$module],
            ['controller','eq',$controller],
            ['method','eq',$method],
        ])->find();

        if($rightInfo){
            //查找哪些角色有此权限
            $roleRight = RoleRightModel::field('')->where([
                ['right_id','eq',$rightInfo['id']],
            ])->select()->toArray();

            if(array_intersect(array_column($adminRole,'role_id'),array_column($roleRight,'role_id'))){
                return true;
            }

            abort(401, '无权操作');
        }
    }
}