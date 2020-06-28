<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/28
 * Time: 16:26
 */

namespace app\admin\controller;

use app\common\lib\IAuth;
use app\common\model\permission\Admin as AdminModel;
use think\App;
use think\facade\Session;

class Login extends Base
{
    public function initialize()
    {

    }

    public function login()
    {
        $result = $this->checkLogin();
        if($result === false){
            return $this->fetch();
        }

        return $this->redirect('/admin/index/index');
    }

    public function dologin()
    {
        $data = $this->request->only('admin_name,password','post');

        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Admin.login');
        if($validateResult !== true){
            return $this->result([],102,$validateResult,'json');
        }

        $admin = AdminModel::get(function ($query)use ($data){
            $query->where([['admin_name','eq',$data['admin_name']]]);
        });

        if($admin){
            if($admin['password'] == IAuth::setPassword($data['password'])){
                $udata = [
                    'last_time' => time(),
                    'last_ip' => $this->request->ip(),
                ];

                try{
                    AdminModel::update($udata,[['id','eq',$admin->id]]);
                }catch (\Exception $e){
                    return $this->result([],105,$e->getMessage(),'json');
                }

                Session::set('admin_login_session',$admin->id);
                return $this->result([],100,'登录成功！','json');
            }else{
                return $this->result([],1103,'密码错误','json');
            }
        }else{
            return $this->result([],1104,'用户不存在!','json');
        }

        return $this->result([],1101,'登陆失败!','json');
    }

    public function logout()
    {
        try{
            Session::delete('admin_login_session');
        }catch (\Exception $e){
            return $this->result([],105,$e->getMessage(),'json');
        }

        return $this->result([],100,'退出成功！','json');
    }
}