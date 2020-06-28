<?php
namespace app\admin\controller;

use think\Controller;
use app\common\logic\permission\Right as RightLogic;

class Index extends Base
{
    public function index()
    {
        $rightLogic = new RightLogic();
        $tree = $rightLogic->getMenuTree();
        $this->assign('rightTree',$tree);
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
