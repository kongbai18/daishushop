<?php

namespace app\admin\controller\permission;

use think\Controller;
use app\common\model\permission\Admin as AdminModel;
use app\common\model\permission\Role as RoleModel;
use app\common\logic\permission\Admin as AdminLogic;

class Admin extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = $this->request->param();
        $adminModel = new AdminModel();
        $list = $adminModel->getList($data);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $roleList = RoleModel::cache('admin_role_list')->all();
        $this->assign('roleList',$roleList);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Admin.save');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
        }

        //数据处理与存储
        if(isset($data['role']) && is_array($data['role'])){
            $role = array_keys($data['role']);
            $roleList = RoleModel::where([['id','in',$role]])->field('id as role_id')->select()->toArray();
        }else{
            $roleList = [];
        }

        $adminLogic = new AdminLogic();
        $result = $adminLogic->saveAdminAndRole($data,$roleList);

        if($result['status']){
            return  $this->result([],100,$result['msg']);
        }

        return  $this->result([],105,$result['msg']);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //验证数据是否存在
        $info = AdminModel::get($id,'role');
        if(!$info){
            return $this->result([],104,'原始数据不存在,无法修改!');

        }

        if($info->id == 1){
            return  $this->result([],103,'无法修改');
        }

        $this->assign('info',$info);


        $roleList = RoleModel::cache('admin_role_list')->all();
        $this->assign('roleList',$roleList);
        $this->assign('role',array_column($info->role->toArray(),'role_id'));

        return  $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update($id)
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Admin.update');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
        }

        //验证数据是否存在
        $info = AdminModel::get($id);
        if(!$info){
            return $this->result([],101,'原始数据不存在,无法修改!');
        }

        if($info->id == 1){
            return  $this->result([],103,'无法修改');
        }

        if(isset($data['password']) && !$data['password']){
            unset($data['password']);
        }

        //数据处理与存储
        if(isset($data['role']) && is_array($data['role'])){
            $role = array_keys($data['role']);
            $roleList = RoleModel::where([['id','in',$role]])->field('id as role_id')->select()->toArray();
        }else{
            $roleList = [];
        }

        $adminLogic = new AdminLogic();
        $result = $adminLogic->updateAdminAndRole($data,$roleList);

        if($result['status']){
            return  $this->result([],100,$result['msg']);
        }

        return  $this->result([],105,$result['msg']);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
