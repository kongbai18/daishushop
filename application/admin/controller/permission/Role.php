<?php

namespace app\admin\controller\permission;

use think\Controller;
use think\Db;
use think\Request;

use app\common\model\permission\Role as RoleModel;
use app\common\model\permission\Right as RightModel;
use app\common\logic\permission\Role as RoleLogic;
use app\common\model\permission\RoleRight as RoleRightModel;

class Role extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = $this->request->param();
        $roleModel = new RoleModel();
        $list = $roleModel->getList($data);
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
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     * @return \think\Response
     */
    public function save()
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Role.save');
        if($validateResult !== true){
            return $this->result([],102,$validateResult);
        }

        //数据处理与存储
        if(isset($data['right']) && is_array($data['right'])){
            $right= array_values($data['right']);
            $rightList = RightModel::where([['id','in',$right]])->field('id as right_id')->select()->toArray();
        }else{
            $rightList = [];
        }
        $roleLogic = new RoleLogic();
        $result = $roleLogic->saveRoleAndRight($data,$rightList);

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
        $info = RoleModel::get($id,'',true);
        if(!$info){
            return $this->result([],104,'原始数据不存在,无法修改!');
        }

        $this->assign('info',$info);
        return $this->fetch();
    }

    public function getRoleRight($id)
    {
        $list = RoleRightModel::all(function ($query)use ($id){
            $query->where([['role_id','eq',$id]])->field('right_id');
        })->toArray();

        return $this->result(array_column($list,'right_id'),100,'获取成功');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update()
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Role.update');
        if($validateResult !== true){
            return $this->result([],102,$validateResult);
        }

        $info = RoleModel::get($data['id']);
        if(!$info){
            return $this->result([],104,'原始数据不存在!');
        }

        //数据处理与存储
        if(isset($data['right']) && is_array($data['right'])){
            $right= array_values($data['right']);
            $rightList = RightModel::where([['id','in',$right]])->field('id as right_id')->select()->toArray();
        }else{
            $rightList = [];
        }
        $roleLogic = new RoleLogic();
        $result = $roleLogic->updateRoleAndRight($data,$rightList);

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
        Db::startTrans();
        try{
            RoleModel::destroy($id);
            RoleRightModel::destroy(function ($query)use ($id){
                $query->where([['role_id','eq',$id]]);
            });
        }catch (\Exception $e){
            Db::rollback();
            return $this->result([],105,$e->getMessage());
        }

        Db::commit();
        return $this->result([],100,'删除成功');

    }

    public function deleteBatch()
    {
        $ids = $this->request->param('ids');
        Db::startTrans();
        try{
            RoleModel::destroy(function ($query)use ($ids){
                $query->where([['id','in',$ids]]);
            });
            RoleRightModel::destroy(function ($query)use ($ids){
                $query->where([['role_id','in',$ids]]);
            });
        }catch (\Exception $e){
            Db::rollback();
            return $this->result([],105,$e->getMessage());
        }

        Db::commit();
        return $this->result([],100,'删除成功');
    }
}
