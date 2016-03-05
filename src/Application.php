<?php
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

