<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/9
 * Time: 11:59
 */

namespace app\common\logic\upload;


class Local
{
    public function saveFile($file)
    {
        $info = $file->move(env('root_path').'/public/upload');
        if($info){
            return [
                'status' => true,
                'msg'    => '',
                'data'   => '/upload/'.$info->getSaveName(),
            ];
        }else{
            return [
                'status' => true,
                'msg'    => $file->getError(),
                'data'   => '',
            ];
        }
    }
}