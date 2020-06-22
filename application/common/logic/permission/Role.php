<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/22
 * Time: 15:30
 */

namespace app\common\logic\permission;

use app\common\model\permission\Role as RoleModel;
use think\Db;

class Role
{
    /**
     * 新增角色及角色权限
     * @param $roleData 角色信息
     * @param array $rightData 权限信息
     * @return array
     *User: ligo
     */
    public function saveRoleAndRight($roleData,$rightData = [])
    {
        Db::startTrans();
        try{
            $roleModel = new RoleModel();
            $roleModel->save($roleData);
            $roleModel->right()->saveAll($rightData);
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
     * 修改角色信息及关联权限
     * @param $roleData 角色信息
     * @param array $rightData 权限信息
     * @return array
     *User: ligo
     */
    public function updateRoleAndRight($roleData,$rightData = [])
    {
        Db::startTrans();
        try{
            $roleModel = new RoleModel();
            $roleModel->save($roleData,['id',$roleData['id']]);
            $roleModel->right()->where('role_id',$roleData['id'])->delete();
            $roleModel->right()->saveAll($rightData);
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