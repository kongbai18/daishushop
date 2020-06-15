<?php

namespace app\common\validate\right;

use think\Validate;

class Admin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'id|id'                => 'require|integer',
	    'admin_name|用戶名'     => 'require|max:30|unique:admin,admin_name',
        'password|密码'         => 'require|alphaDash|length:6,16',
        'repassword|重复密码'   =>  'require|confirm:password',
        'email|邮箱'            => 'require|email|unique:admin,email',
        'avatar|头像'           => 'url',
        'status|状态'           => 'in:1,2',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene = [
        'id' => ['id'],
        'save' => ['admin_name','password','repassword','email'],
    ];

    public function sceneUpdate()
    {
        return $this->only(['id','admin_name','password','email'])
            ->remove('password','require')
            ->remove('repassword','require');
    }
}
