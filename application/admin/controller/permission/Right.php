<?php

namespace app\admin\controller\permission;

use app\admin\controller\Base;
use app\common\model\permission\Right as RightModel;
use app\common\logic\permission\Right as RightLogic;

class Right extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(RightLogic $rightLogic)
    {
        $list = $rightLogic->getLikeTree();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function getTree()
    {
        $rightLogic = new RightLogic();
        $tree = $rightLogic->getTree();
        return $this->result($tree,100,'获取成功','json');
    }

    public function getLikeTree()
    {
        $rightLogic = new RightLogic();
        $tree = $rightLogic->getLikeTree();
        return $this->result($tree,100,'获取成功','json');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $parentId = $this->request->param('parent_id');
        if(is_numeric($parentId)){
            $info = RightModel::get($parentId);
        }else{
            $info = [
                'id' => 0,
                'name' => '作为顶级',
            ];
        }
        $this->assign('info',$info);
        return  $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @return \think\Response
     */
    public function save()
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Right.save');
        if($validateResult !== true){
            return $this->result([],102,$validateResult);
        }

        try{
            $rightModel = new RightModel();
            $rightModel->save($data);
        }catch (\Exception $e){
            return  $this->result([],105,$e->getMessage());
        }

        return  $this->result([],100,'新增成功');
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
        $info = RightModel::get($id);
        if(!$info){
            return $this->result([],101,'数据不存在');
        }

        if($info->parent_id == 0){
            $info->parent_name = '作为顶级';
        }else{
            $parent = RightModel::get($info->parent_id);
            $info->parent_name = $parent->name;
        }

        $this->assign('info',$info);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(RightModel $rightModel)
    {
        $data = $this->request->param();
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Right.update');
        if($validateResult !== true){
            return $this->result([],102,$validateResult);
        }

        try{
            $rightModel->update($data,['id',$data['id']]);
        }catch (\Exception $e){
            return  $this->result([],105,$e->getMessage());
        }

        return  $this->result([],100,'修改成功');
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

    public function changeSort(RightModel $rightModel)
    {
        $data = $this->request->only('id,sort');
        //数据验证
        $validateResult = $this->validate($data,'app\common\validate\permission\Right.sort');
        if($validateResult !== true){
            return $this->result([],102,$validateResult,'json');
        }

        try{
            $rightModel->update($data,['id',$data['id']]);
        }catch (\Exception $e){
            return  $this->result([],105,$e->getMessage(),'json');
        }

        return  $this->result([],100,'修改成功','json');
    }
}
