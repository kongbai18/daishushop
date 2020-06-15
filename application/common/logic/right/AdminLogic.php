<?php


namespace app\common\logic\right;


use app\common\model\right\Admin;
use think\Db;

class AdminLogic
{
    public function saveAdminAndRole($adminData,$roleData = [])
    {
        Db::startTrans();
        try{
            $adminModel = new Admin();
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

    public function updateAdminAndRole($adminData,$roleData = [])
    {
        Db::startTrans();
        try{
            $adminModel = new Admin();
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