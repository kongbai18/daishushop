<?php

namespace app\admin\controller\right;

use think\Controller;
use think\Request;
use app\common\model\right\Admin as AdminModel;
use app\common\model\right\Role as RoleModel;
use app\common\logic\right\AdminLogic;

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
        $roleList = RoleModel::cache('role_list')->all();
        $this->assign('roleList',$roleList);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\right\Admin.save');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
        }

        //数据处理与存储
        if(isset($data['role']) && is_array($data['role'])){
            $role = array_keys($data['role']);
            $roleList = RoleModel::where(['id','in',$role])->field('id as role_id')->select();
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
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\right\Admin.id');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
        }

        //验证数据是否存在
        $info = AdminModel::get($data['id']);
        if(!$info){
            return $this->result([],101,'原始数据不存在,无法修改!');
        }
        $this->assign('info',$info);

        $roleList = RoleModel::cache('role_list')->all();
        $this->assign('roleList',$roleList);

        return  $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\right\Admin.update');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
        }

        //验证数据是否存在
        $info = AdminModel::get($data['id']);
        if(!$info){
            return $this->result([],101,'原始数据不存在,无法修改!');
        }

        if(isset($data['password']) && !$data['password']){
            unset($data['password']);
        }

        //数据处理与存储
        if(isset($data['role']) && is_array($data['role'])){
            $role = array_keys($data['role']);
            $roleList = RoleModel::where(['id','in',$role])->field('id as role_id')->select();
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
