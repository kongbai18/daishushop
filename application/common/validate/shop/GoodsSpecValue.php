<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/13
 * Time: 14:34
 */

namespace app\common\validate\shop;

use think\Validate;

class GoodsSpecValue extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|id'          => 'require|integer',
        'spec_value|规格值'   => 'require|max:255',
        'spec_value_alt|规格值标记'   => 'require|max:255',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'save'   => ['spec_value','spec_value_alt'],
        'update'   => ['id','spec_value','spec_value_alt'],
    ];
}