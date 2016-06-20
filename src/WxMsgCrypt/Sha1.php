<?php
/**
 * Sha1
 * 计算公众平台的消息签名接口
 *
 * @author 李扬(Andy) <php360@qq.com>
 * @link 技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Agile\Weixin\WxMsgCrypt;

class Sha1
{
    /**
     * 用SHA1算法生成安全签名
     * @param string $token 票据
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $encryptMsg 密文消息
     * @return array
     */
    public function getSHA1($token, $timestamp, $nonce, $encryptMsg)
    {
        //排序
        try {
            $array = array($encryptMsg, $token, $timestamp, $nonce);
            sort($array, SORT_STRING);
            $str = implode($array);

            return array(ErrorCode::$OK, sha1($str));
        } catch (\Exception $e) {
            //print $e . "\n";
            return array(ErrorCode::$ComputeSignatureError, null);
        }
    }

}