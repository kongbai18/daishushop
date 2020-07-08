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
            $data = [
                'id' => time() - 159111111,
                'img_url' => 'https://dss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=3892521478,1695688217&fm=26&gp=0.jpg'
            ];
            $this->result($data,100,'','json');
        }else{
            $data = $this->request->param();
            if (empty($data["filetype"])) {
                $data["filetype"] = "image";
            }
            if (empty($data["multi"])) {
                $multi = 0;
                $maxFiles = 1;
            }else{
                $multi = 1;
                $maxFiles = intval($data['multi']);
            }

            $fileType = $data["filetype"];

            $uploadSetting = config('file.');
            $arrFileTypes = [
                'image' => ['title' => 'Image files', 'extensions' => $uploadSetting['file_types']['image']['extensions']],
                'video' => ['title' => 'Video files', 'extensions' => $uploadSetting['file_types']['video']['extensions']],
                'audio' => ['title' => 'Audio files', 'extensions' => $uploadSetting['file_types']['audio']['extensions']],
                'file'  => ['title' => 'Custom files', 'extensions' => $uploadSetting['file_types']['file']['extensions']]
            ];

            if (array_key_exists($fileType, $arrFileTypes)) {
                $extensions                = $uploadSetting['file_types'][$fileType]['extensions'];
                $fileTypeUploadMaxFileSize = $uploadSetting['file_types'][$fileType]['upload_max_filesize'];
            } else {
                $this->error('上传文件类型配置错误！');
            }
            $this->assign('extensions',$extensions);
            $this->assign('max_file_size',$fileTypeUploadMaxFileSize);
            $this->assign('filetype',$fileType);
            $this->assign('multi', $multi);
            $this->assign('max_files', $maxFiles);
            return $this->fetch();
        }
    }
}