<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/6
 * Time: 15:31
 */

namespace app\admin\controller\upload;


use app\admin\controller\Base;

class Upload extends Base
{
    public function uploadImage()
    {
        if($this->request->isPost()){

        }else{
            return $this->fetch();
        }
    }
}