<?php
/**
 * 与微信服务器交互模块
 *
 * @author    李扬(Andy) <php360@qq.com>
 * @link      技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
namespace Agile\Weixin;

class Weixin
{
    /**
     * Token
     *
     * @var string
     */
    private $token = '';

    /**
     * 设置token
     *
     * @param string $token Token值
     * @return $this
     */
    public function token($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * 验证服务器，接收POST消息
     *
     * @return array
     */
    public function run()
    {
        if (empty($this->token)) {
            return false;
        }

        // 验证服务器
        $this->checkSignature();

        // 接收post消息
        libxml_disable_entity_loader(true);
        $postData = (array) simplexml_load_string(
            file_get_contents("php://input"),
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );

        if (empty($postData)) {
            return false;
        }

        return $postData;
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

            if ($tmpStr == $signature) {
                echo $_GET['echostr'];
                die();
            }
        }
    }

}
