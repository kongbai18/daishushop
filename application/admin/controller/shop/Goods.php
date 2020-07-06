<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/3
 * Time: 17:27
 */

namespace app\admin\controller\shop;


use app\admin\controller\Base;

class Goods extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function create()
    {
        return $this->fetch();
    }

    public function save()
    {

    }
}