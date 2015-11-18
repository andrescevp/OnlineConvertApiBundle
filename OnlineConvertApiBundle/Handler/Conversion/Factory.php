<?php

namespace Aacp\OnlineConvertApiBundle\Handler\Conversion;


use Qaamgo\Job\Interfaced;
use Qaamgo\Job\Sync;
use Qaamgo\Job\ASync;
use Symfony\Component\Config\Loader\Loader;

class Factory
{
    /**
     * @var Sync|Async
     */
    protected $syncJobCreator;
    protected $asyncJobCreator;

    protected $loader;

    protected $host;

    public function __construct(Interfaced $syncJobCreator, Interfaced $asyncJobCreator, Loader $loader, $host)
    {
        $this->syncJobCreator = $syncJobCreator;
        $this->loader = $loader;
        $this->asyncJobCreator = $asyncJobCreator;
        $this->host = $host;
    }

    public function getConverter($category = '', $target = '', $async = false)
    {
        $converter =
            $async ?
                new ConversionAsync($this->asyncJobCreator, $this->loader, $this->host) :
                new ConversionSync($this->syncJobCreator);
        $converter->category = $category;
        $converter->target = $target;

        return $converter;
    }
}