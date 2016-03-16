<?php
/**
 * Agile/Weixin框架
 *
 * @author    李扬(Andy) <php360@qq.com>
 * @link      技安后院 http://www.moqifei.com
 * @copyright 苏州幻果软件有限公司 http://www.huanguosoft.com
 * @listen    http://www.apache.org/licenses/LICENSE-2.0
 */
namespace Agile\Weixin;

use Agile\Weixin\Contracts\Application as ApplicationContract;

class Application implements ApplicationContract
{
    /**
     * The AgileWeixin development package version.
     *
     * @var string
     */
    const VERSION = '1.0';

    /**
     * Get the version num of the weixin package.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }
}

