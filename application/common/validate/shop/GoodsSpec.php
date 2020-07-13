<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/7/13
 * Time: 14:23
 */

namespace app\common\validate\shop;

use think\Validate;

class GoodsSpec extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|id'          => 'require|integer',
        'spec_name|规格名称'   => 'require|max:255',
        'type|规格类型'   => 'require|in:1,2',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'save'   => ['spec_name','type'],
        'update'   => ['id','spec_name','type'],
    ];
}