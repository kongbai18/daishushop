<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/17
 * Time: 14:41
 */

namespace app\common\logic\permission;

use app\common\model\permission\Right as RightModel;

class Right
{
    /**
     * 获取树形结构（多级数组）
     * @return array
     *User: ligo
     */
    public function getTree()
    {
        $list = RightModel::all(function ($query){
            $query->order('sort asc');
        },'','admin_right_list');
        return $this->_getTree($list);
    }

    public function getMenuTree()
    {
        $list = RightModel::all(function ($query){
            $query->where([['is_menu','eq',1]])->order('sort asc');
        },'','admin_right_menu_list');
        return $this->_getTree($list);
    }

    /**
     * 获取类树形结构 一维数组
     * @return array
     *User: ligo
     */
    public function getLikeTree()
    {
        $list = RightModel::all(function ($query){
            $query->order('sort asc');
        },'','admin_right_list');
        return $this->_getLikeTree($list);
    }

    /**
     * 类树形结构转换
     * @param $data
     * @param int $parentId
     * @param int $level
     * @return array
     *User: ligo
     */
    private function _getLikeTree($data, $parentId = 0, $level = 0){
        static $ret = [];
        foreach($data as $k => $v){
            if($v['parent_id'] == $parentId){
                $v['level'] = $level;
                $ret[] = $v;
                //找子分类
                $this->_getLikeTree($data,$v['id'],$level+1);
            }
        }
        return $ret;
    }

    /**
     * 转树形结构
     * @param $data
     * @param int $parentId
     * @return array
     *User: ligo
     */
    private function _getTree($data, $parentId = 0){
        $ret = [];
        foreach($data as $k => $v){
            if($v['parent_id'] == $parentId){
                $v['children'] = $this->_getTree($data,$v['id']);
                if (!$v['children']) {
                    unset($v['children']);
                }
                $ret[] = $v;
            }
        }
        return $ret;
    }
}