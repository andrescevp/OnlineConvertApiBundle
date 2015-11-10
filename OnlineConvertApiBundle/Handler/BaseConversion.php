<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 10/11/2015
 * Time: 22:29
 */

namespace Aacp\OnlineConvertApiBundle\Handler;


class BaseConversion extends  Conversion
{
    protected $logger;

    public function __construct($apiKey, $decoratorName, $logger, $category = null, $target = null, $https = false)
    {
        parent::__construct($apiKey, $decoratorName, $category, $target, $https);
    }

    /**
     * Use this method to add yourself events when look the status of the Job
     *
     * @return mixed
     */
    protected function dispatch()
    {
        $this->logger->info('Job success');
    }
}