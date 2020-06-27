<?php


namespace app\common\logic\permission;


use app\common\model\permission\Admin as AdminModel;
use think\Db;

class Admin
{
    /**
     * 新增管理员及关联角色
     * @param $adminData 管理员信息
     * @param array $roleData 角色信息
     * @return array
     *User: ligo
     */
    public function saveAdminAndRole($adminData,$roleData = [])
    {
        Db::startTrans();
        try{
            $adminModel = new AdminModel();
            $adminModel->save($adminData);
            $adminModel->role()->saveAll($roleData);
        }catch (\Exception $e){
            Db::rollback();
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
            ];
        }

        Db::commit();
        return [
            'status' => true,
            'msg'    => '添加成功',
        ];
    }

    /**
     * 修改管理员信息 及关联角色
     * @param $adminData 管理员信息
     * @param array $roleData 角色信息
     * @return array
     *User: ligo
     */
    public function updateAdminAndRole($adminData,$roleData = [])
    {
        Db::startTrans();
        try{
            $adminModel = new AdminModel();
            $adminModel->save($adminData,['id',$adminData['id']]);
            $adminModel->role()->where('admin_id',$adminData['id'])->delete();
            $adminModel->role()->saveAll($roleData);
        }catch (\Exception $e){
            Db::rollback();
            return [
                'status' => false,
                'msg'    => $e->getMessage(),
            ];
        }

        Db::commit();
        return [
            'status' => true,
            'msg'    => '修改成功',
        ];
    }
}