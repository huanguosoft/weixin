<?php
namespace Agile\Weixin;

class Weixin
{
    /**
     * Token
     *
     * @var string
     */
    private $token;

    /**
     * AppID
     *
     * @var string
     */
    private $appId = '';

    /**
     * AppSecret
     *
     * @var string
     */
    private $appSecret = '';

    /**
     * EncodingAESKey,消息加解密密钥
     *
     * @var string
     */
    private $encodingAESKey = '';

    /**
     * 开发者模式
     *
     * @var bool
     */
    private $debug = false;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * 开发者模式开启
     * @return $this
     */
    public function debug()
    {
        $this->debug = true;

        return $this;
    }

    public static function run()
    {
        // 验证服务器
        self::checkSignature();

        $postData = file_get_contents("php://input");
        libxml_disable_entity_loader(true);
        $postData = simplexml_load_string($postData, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($postData === false) {
            return false;
        }

        return Msg::requestMsg($postData);
    }


    /**
     * 检验signature
     */
    private function checkSignature()
    {
        if (isset($_GET['echostr'])) {
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce     = $_GET["nonce"];

            $tmpArr = array($this->token, $timestamp, $nonce);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode($tmpArr);
            $tmpStr = sha1($tmpStr);

            if($tmpStr == $signature ){
                echo $_GET['echostr'];
                exit();
            }
        }
    }
}
