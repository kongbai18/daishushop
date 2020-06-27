<?php

namespace app\admin\controller\permission;

use think\Controller;
use think\Request;

use app\common\model\permission\Role as RoleModel;
use app\common\model\permission\Right as RightModel;
use app\common\logic\permission\Role as RoleLogic;

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
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save()
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Role.save');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
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
        //
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
        //
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
