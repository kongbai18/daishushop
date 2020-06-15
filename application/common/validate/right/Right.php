<?php

namespace app\common\validate\right;

use think\Validate;

class Right extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'id|id'         => 'require|integer',
        'name|权限名称'  => 'require|max:30',
        'module|应用'  => 'require|alpha|unique:right,module^controller^method',
        'controller|控制器'  => 'require|alpha',
        'method|方法'  => 'require|alpha',
        'icon|图标'      => 'max:255',
        'parent_id|上级id' => 'require|integer',
        'sort|排序'     => 'require|integer',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'save' => ['name','module','controller','method','icon','parent_id','sort'],
    ];
}
