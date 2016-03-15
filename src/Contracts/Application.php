<?php
namespace Agile\Weixin\Contracts;
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 16/3/5
 * Time: 18:00
 */

interface Application
{
    /**
     * Get the version num of the weixin package.
     *
     * @return string
     */
    public function version();
}
