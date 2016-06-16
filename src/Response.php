<?php
/**
 * 微信消息被动回复
 *
 * @author 李扬(Andy) <php360@qq.com>
 * @link 技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
namespace Agile\Weixin;

class Response
{
    /**
     * 记录当前时间
     *
     * @var string
     */
    private $time;

    /**
     * 图文信息数组
     *
     * @var array
     */
    private $news = [];

    /**
     * 初始化时间
     *
     * Response constructor.
     */
    public function __construct()
    {
        $this->time = time();
    }

    /**
     * 回复文本消息
     *
     * @param string $fromUserName 接收方帐号（收到的OpenID）
     * @param string $toUserName 开发者微信号
     * @param string $text 回复的消息内容（换行：在content中能够换行，微信客户端就支持换行显示）
     * @param int $funcFlag 默认为0，1:标星消息
     * @return string 返回的文本信息
     */
    public function text($fromUserName, $toUserName, $text, $funcFlag = 0)
    {
        $tpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";

        return sprintf($tpl, $fromUserName, $toUserName, $this->time, $text, $funcFlag);
    }

    /**
     * 回复图片消息
     *
     * @param string $fromUserName 接收方帐号（收到的OpenID）
     * @param string $toUserName 开发者微信号
     * @param string $mediaId 通过素材管理接口上传多媒体文件，得到的id
     * @param int $funcFlag 默认为0，1:标星消息
     * @return string
     */
    public function image($fromUserName, $toUserName, $mediaId, $funcFlag = 0)
    {
        $tpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[image]]></MsgType>
            <Image>
                <MediaId><![CDATA[%s]]></MediaId>
            </Image>
            <FuncFlag>%s</FuncFlag>
            </xml>";

        return sprintf($tpl, $fromUserName, $toUserName, $this->time, $mediaId, $funcFlag);
    }

    /**
     * 回复语音消息
     *
     * @param string $fromUserName 接收方帐号（收到的OpenID）
     * @param string $toUserName 开发者微信号
     * @param string $mediaId 通过素材管理接口上传多媒体文件，得到的id
     * @param int $funcFlag 默认为0，1:标星消息
     * @return string
     */
    public function voice($fromUserName, $toUserName, $mediaId, $funcFlag = 0)
    {
        $tpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[voice]]></MsgType>
            <Voice>
                <MediaId><![CDATA[%s]]></MediaId>
            </Voice>
            <FuncFlag>%s</FuncFlag>
            </xml>";

        return sprintf($tpl, $fromUserName, $toUserName, $this->time, $mediaId, $funcFlag);
    }

    /**
     * 回复视频消息
     *
     * @param string $fromUserName 接收方帐号（收到的OpenID）
     * @param string $toUserName 开发者微信号
     * @param string $mediaId 通过素材管理接口上传多媒体文件，得到的id
     * @param string $title 视频消息的标题
     * @param string $description 视频消息的描述
     * @param int $funcFlag 默认为0，1:标星消息
     * @return string
     */
    public function video($fromUserName, $toUserName, $mediaId, $title = '', $description = '', $funcFlag = 0)
    {
        $tpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[video]]></MsgType>
            <Video>
                <MediaId><![CDATA[%s]]></MediaId>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
            </Video>
            <FuncFlag>%s</FuncFlag>
            </xml>";

        return sprintf($tpl, $fromUserName, $toUserName, $this->time, $mediaId, $title, $description, $funcFlag);
    }

    /**
     * 回复音乐消息
     *
     * @param string $fromUserName 接收方帐号（收到的OpenID）
     * @param string $toUserName 开发者微信号
     * @param string $title 音乐标题
     * @param string $description 音乐描述
     * @param string $musicUrl 音乐链接
     * @param string $hqMusicUrl 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param string $thumbMediaId 缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
     * @param int $funcFlag 默认为0，1:标星消息
     * @return string
     */
    public function music($fromUserName, $toUserName, $title = '', $description = '', $musicUrl = '', $hqMusicUrl = '', $thumbMediaId = '', $funcFlag = 0)
    {
        $tpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[music]]></MsgType>
            <Music>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <MusicUrl><![CDATA[%s]]></MusicUrl>
                <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
            </Music>
            <FuncFlag>%s</FuncFlag>
            </xml>";

        return sprintf($tpl, $fromUserName, $toUserName, $this->time, $title, $description, $musicUrl, $hqMusicUrl, $thumbMediaId, $funcFlag);
    }

    public function news($fromUserName, $toUserName)
    {
        $count = count($this->news);
        if ($count > 0 && $count <= 10) {
            $articleItem = "<item>
                <Title><![CDATA[%s]]></Title> 
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>";

            $articles = '';
            foreach ($this->news as $value) {
                $articles .= sprintf(
                    $articleItem,
                    $value['title'],
                    $value['descript'],
                    $value['picUrl'],
                    $value['url']
                );
            }

            $tpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>%s</ArticleCount>
                <Articles>
                %s
                </Articles>
                </xml>";

            return sprintf($tpl, $fromUserName, $toUserName, $this->time, $count, $articles);
        }
    }

    /**
     * 组织图文数据数组
     *
     * @param string $title
     * @param string $description
     * @param string $picUrl
     * @param string $url
     * @return $this
     */
    public function setNews($title, $description, $picUrl, $url)
    {
        $this->news = array_merge($this->news, [
            'title'     => $title,
            'descript'  => $description,
            'picUrl'    => $picUrl,
            'url'       => $url,
        ]);

        return $this;
    }
}
