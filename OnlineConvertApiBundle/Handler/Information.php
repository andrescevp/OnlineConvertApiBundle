<?php

namespace Aacp\OnlineConvertApiBundle\Handler;


use Aacp\OnlineConvertApiBundle\Decorator\Factory;
use SwaggerClient\InformationApi;
use Aacp\OnlineConvertApiBundle\Decorator\Interfaced as InterfacedDecorator;
class Information
{
    /**
     * @var InformationApi
     */
    private $info;

    /**
     * @var InterfacedDecorator
     */
    private $decorator;

    private $apiKey;

    public function __construct(InformationApi $informationApi, $apiKey, $decoratorName = null)
    {
        $this->info = $informationApi;
        $this->apiKey = $apiKey;
        if ($decoratorName === null) {
            $decoratorName = 'json';
        }
        $decoratorFactory = new Factory($decoratorName);
        $this->decorator = $decoratorFactory->getDecorator();
    }

    public function getSchema()
    {
        return $this->decorator->pretty(
            $this->info->getSchema()
        );
    }

    public function getStatuses()
    {
        return $this->decorator->pretty(
            $this->info->statusesGet()
        );
    }

    public function getConversionInfo($category, $target, $page)
    {
        return $this->decorator->pretty(
            $this->info->conversionsGet($category, $target, $page)
        );
    }
}