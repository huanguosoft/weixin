<?php
namespace Agile\Weixin\Contracts;

interface Application
{
    /**
     * Get the version num of the weixin package.
     *
     * @return string
     */
    public function version();
}
