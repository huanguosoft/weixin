<?php
/**
 * 接收事件推送
 *
 * @author 李扬(Andy) <php360@qq.com>
 * @link 技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Agile\Weixin;

class Event
{
    /**
     * 记录当前时间
     *
     * @var string
     */
    private $time;

    /**
     * 初始化时间
     *
     * Response constructor.
     */
    public function __construct()
    {
        $this->time = time();
    }

    public function subscribe()
    {
        // 订阅
    }

    public function unsubscribe()
    {
        // 取消订阅
    }

    public function scan()
    {
        // 用户已关注时的事件推送
    }

    public function location()
    {
        // 上报地理位置事件
    }

    public function click()
    {
        // 点击推事件
    }

    public function view()
    {
        // 跳转URL
    }

    public function scancodePush()
    {
        // 扫码推事件
    }

    public function scancodeWaitmsg()
    {
        // 扫码推事件且弹出“消息接收中”提示框
    }

    public function picSysphoto()
    {
        // 弹出系统拍照发图
    }

    public function picPhotoOrAlbum()
    {
        // 弹出拍照或者相册发图
    }

    public function picWeixin()
    {
        // 弹出微信相册发图器
    }

    public function locationSelect()
    {
        // 弹出地理位置选择器
    }

    public function mediaId()
    {
        // 下发消息（除文本消息）
    }

    public function viewLimited()
    {
        // 跳转图文消息URL
    }

}