<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/8
 * Time: 13:06
 */

return [
    'file_types' => [
        'image' => [
            'upload_max_filesize' => '51200',//单位KB
            'extensions'          => 'jpg,jpeg,png,gif,bmp4'
        ],
        'video' => [
            'upload_max_filesize' => '51200',
            'extensions'          => 'mp4,avi,wmv,rm,rmvb,mkv'
        ],
        'audio' => [
            'upload_max_filesize' => '51200',
            'extensions'          => 'mp3,wma,wav'
        ],
        'file'  => [
            'upload_max_filesize' => '51200',
            'extensions'          => 'txt,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar'
        ]
    ],
    'chunk_size' => 512,//单位KB
    'max_files'  => 20 //最大同时上传文件数
];