<?php
/**
 * 微信消息加解密
 *
 * @author 李扬(Andy) <php360@qq.com>
 * @link 技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Agile\Weixin;

use Agile\Weixin\WxMsgCrypt\ErrorCode;
use Agile\Weixin\WxMsgCrypt\Sha1;
use Agile\Weixin\WxMsgCrypt\XmlParse;
use Agile\Weixin\WxMsgCrypt\Prpcrypt;

class WxMsgCrypt
{
    /**
     * Token
     *
     * @var string
     */
    private $token = '';

    /**
     * appid
     *
     * @var string
     */
    private $appId = '';

    /**
     * 加密秘钥
     *
     * @var string
     */
    private $encodingAesKey = '';

    /**
     * 构造函数
     * @param string $token token
     * @param string $appId appId
     * @param string $encodingAesKey AES加密密钥
     */
    public function __construct($token, $appId, $encodingAesKey)
    {
        $this->token          = $token;
        $this->appId          = $appId;
        $this->encodingAesKey = $encodingAesKey;
    }

    /**
     * 加密数据信息
     *
     * @param string $data 未加密数据信息，XML数据
     * @param string $timestamp
     * @param string $nonce
     * @return int|string
     */
    public function encryptMsg($data, $timestamp, $nonce)
    {
        // 加密数据
        $encryptMsg = '';

        // 加密数据
        $errCode = $this->_encryptMsg(
            $data,
            $timestamp,
            $nonce,
            $encryptMsg
        );

        if ($errCode == 0) {
            // 返回加密数据
            return $encryptMsg;
        }

        return $errCode;
    }

    /**
     * 解密数据
     *
     * @param string $encrypt 已加密的数据信息
     * @param string $msgSignature 签名串，对应URL参数的msg_signature
     * @param string $timestamp 时间戳 对应URL参数的timestamp
     * @param string $nonce 随机串，对应URL参数的nonce
     * @return array|bool|int
     */
    public function decryptMsg($encrypt, $msgSignature, $timestamp, $nonce)
    {
        // 解密消息
        $fromXml = sprintf(
            "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>",
            $encrypt
        );

        // 被解密消息
        $decryptMsg = '';

        // 被解密消息结果错误代码，为0表示无错误
        $errCode = $this->_decryptMsg(
            $msgSignature,
            $timestamp,
            $nonce,
            $fromXml,
            $decryptMsg
        );

        if ($errCode == 0) {
            // 把解密的xml转换成数组
            return (array) simplexml_load_string(
                $decryptMsg,
                'SimpleXMLElement',
                LIBXML_NOCDATA
            );
        }

        return $errCode;
    }

    /**
     * 将公众平台回复用户的消息加密打包.
     * <ol>
     *    <li>对要发送的消息进行AES-CBC加密</li>
     *    <li>生成安全签名</li>
     *    <li>将消息密文和安全签名打包成xml格式</li>
     * </ol>
     *
     * @param $replyMsg string 公众平台待回复用户的消息，xml格式的字符串
     * @param $timeStamp string 时间戳，可以自己生成，也可以用URL参数的timestamp
     * @param $nonce string 随机串，可以自己生成，也可以用URL参数的nonce
     * @param &$encryptMsg string 加密后的可以直接回复用户的密文，包括msg_signature, timestamp, nonce, encrypt的xml格式的字符串,当return返回0时有效
     *
     * @return int 成功0，失败返回对应的错误码
     */
    private function _encryptMsg($replyMsg, $timeStamp, $nonce, &$encryptMsg)
    {
        $pc = new Prpcrypt($this->encodingAesKey);

        //加密
        $array = $pc->encrypt($replyMsg, $this->appId);
        $ret = $array[0];
        if ($ret != 0) {
            return $ret;
        }

        if ($timeStamp == null) {
            $timeStamp = time();
        }
        $encrypt = $array[1];

        //生成安全签名
        $sha1 = new Sha1;
        $array = $sha1->getSHA1($this->token, $timeStamp, $nonce, $encrypt);
        $ret = $array[0];
        if ($ret != 0) {
            return $ret;
        }
        $signature = $array[1];

        //生成发送的xml
        $xmlparse = new XmlParse;
        $encryptMsg = $xmlparse->generate($encrypt, $signature, $timeStamp, $nonce);

        return ErrorCode::$OK;
    }


    /**
     * 检验消息的真实性，并且获取解密后的明文.
     * <ol>
     *    <li>利用收到的密文生成安全签名，进行签名验证</li>
     *    <li>若验证通过，则提取xml中的加密消息</li>
     *    <li>对消息进行解密</li>
     * </ol>
     *
     * @param $msgSignature string 签名串，对应URL参数的msg_signature
     * @param $timestamp string 时间戳 对应URL参数的timestamp
     * @param $nonce string 随机串，对应URL参数的nonce
     * @param $postData string 密文，对应POST请求的数据
     * @param &$msg string 解密后的原文，当return返回0时有效
     *
     * @return int 成功0，失败返回对应的错误码
     */
    private function _decryptMsg($msgSignature, $timestamp = null, $nonce, $postData, &$msg)
    {
        if (strlen($this->encodingAesKey) != 43) {
            return ErrorCode::$IllegalAesKey;
        }

        $pc = new Prpcrypt($this->encodingAesKey);

        //提取密文
        $xmlparse = new XmlParse;
        $array = $xmlparse->extract($postData);
        $ret = $array[0];

        if ($ret != 0) {
            return $ret;
        }

        if ($timestamp == null) {
            $timestamp = time();
        }

        $encrypt = $array[1];
        // $touser_name = $array[2];

        //验证安全签名
        $sha1 = new Sha1;
        $array = $sha1->getSHA1($this->token, $timestamp, $nonce, $encrypt);
        $ret = $array[0];

        if ($ret != 0) {
            return $ret;
        }

        $signature = $array[1];
        if ($signature != $msgSignature) {
            return ErrorCode::$ValidateSignatureError;
        }

        $result = $pc->decrypt($encrypt, $this->appId);
        if ($result[0] != 0) {
            return $result[0];
        }
        $msg = $result[1];

        return ErrorCode::$OK;
    }

}