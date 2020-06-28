<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/28
 * Time: 15:46
 */

namespace app\common\lib;


use think\Cache;

class IAuth
{
    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static  function setPassword($data, $key = '#pass_@daishu') {
        return strtoupper(md5($data.$key));
    }

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = []) {
        // 1 按字段排序
        ksort($data);
        // 2拼接字符串数据  &
        $string = http_build_query($data);
        // 3通过aes来加密
        $string = (new Aes())->encrypt($string);

        return $string;
    }

    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data) {
        $str = (new Aes())->decrypt($data['sign']);

        if(empty($str)) {
            return false;
        }

        // diid=xx&app_type=3
        parse_str($str, $arr);
        if(!is_array($arr) || empty($arr['did']) || $arr['did'] != $data['did']){
            return false;
        }


        if(!config('app_debug')) {

            if ((time() - ceil($arr['time'] / 1000)) > 20) {
                return false;
            }

            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }
        return true;
    }
}