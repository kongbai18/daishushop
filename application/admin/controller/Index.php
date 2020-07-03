<?php
namespace app\admin\controller;

use app\common\logic\permission\Right as RightLogic;
use app\common\model\permission\Admin as AdminModel;

class Index extends Base
{
    public function index()
    {
        $rightLogic = new RightLogic();
        $tree = $rightLogic->getMenuTree();
        $this->assign('rightTree',$tree);

        $admin = AdminModel::get($this->adminId);
        $this->assign('admin',$admin);
        return $this->fetch();
    }

    public function home(){
        return $this->fetch();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
