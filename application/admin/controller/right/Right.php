<?php

namespace app\admin\controller\right;

use think\Controller;
use think\Request;
use app\common\model\right\Right as RightModel;

class Right extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
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
        $validateResult = $this->validate($data,'app\common\validate\right\Right.save');
        if($validateResult !== true){
            return $this->result([],104,$validateResult);
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
