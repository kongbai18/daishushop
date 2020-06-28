<?php

namespace app\common\validate\permission;

use think\Validate;

class Role extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'id|id'          => 'require|integer',
	    'name|角色名称'   => 'require|max:30',
        'describe|角色描述'   => 'max:255',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'save'   => ['name','describe'],
        'update'   => ['id','name','describe'],
    ];
}
