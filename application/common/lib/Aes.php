<?php
/**
 * Created by PhpStorm.
 * User: ligo
 * Date: 2020/6/28
 * Time: 15:53
 */

namespace app\common\lib;


class Aes
{
    private $key = 'aes_!mdkey#';

    /**
     *
     * @param $key 		密钥
     * @return String
     */
    public function __construct($key = null) {
        if(!is_null($key)){
            $this->key = $key;
        }
    }

    /**
     * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
     * @return HexString
     */
    public function encrypt($input = '') {
        $data = base64_encode(openssl_encrypt($input, 'AES-128-CBC',$this->key, OPENSSL_RAW_DATA, $this->key));

        return $data;
    }

    /**
     * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
     * @return String
     */
    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
     * @return String
     */
    public function decrypt($sStr) {
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,base64_decode($sStr), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);

        return $decrypted;
    }
}