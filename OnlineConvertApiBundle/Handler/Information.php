<?php

namespace Aacp\OnlineConvertApiBundle\Handler;


use Aacp\OnlineConvertApiBundle\Decorator\Factory;
use Qaamgo\InformationApi;
use Aacp\OnlineConvertApiBundle\Decorator\Interfaced as InterfacedDecorator;

class Information
{
    /**
     * @var InformationApi
     */
    private $info;

    private $apiKey;

    public function __construct(InformationApi $informationApi, $apiKey)
    {
        $this->info = $informationApi;
        $this->apiKey = $apiKey;
    }

    public function getSchema()
    {
            $this->info->getSchema();
    }

    public function getStatuses()
    {
            $this->info->statusesGet();
    }

    public function getConversionInfo($category, $target, $page)
    {
            $this->info->conversionsGet($category, $target, $page);
    }
}