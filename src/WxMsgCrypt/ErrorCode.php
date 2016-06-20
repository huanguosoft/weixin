<?php
/**
 * 微信消息加解密错误代码
 *
 * -40001: 签名验证错误
 * -40002: xml解析失败
 * -40003: sha加密生成签名失败
 * -40004: encodingAesKey 非法
 * -40005: appid 校验错误
 * -40006: aes 加密失败
 * -40007: aes 解密失败
 * -40008: 解密后得到的buffer非法
 * -40009: base64加密失败
 * -40010: base64解密失败
 * -40011: 生成xml失败
 *
 * @author 李扬(Andy) <php360@qq.com>
 * @link 技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Agile\Weixin\WxMsgCrypt;

class ErrorCode
{
    public static $OK                       = 0;
    public static $ValidateSignatureError   = -40001;
    public static $ParseXmlError            = -40002;
    public static $ComputeSignatureError    = -40003;
    public static $IllegalAesKey            = -40004;
    public static $ValidateAppidError       = -40005;
    public static $EncryptAESError          = -40006;
    public static $DecryptAESError          = -40007;
    public static $IllegalBuffer            = -40008;
    public static $EncodeBase64Error        = -40009;
    public static $DecodeBase64Error        = -40010;
    public static $GenReturnXmlError        = -40011;
}
