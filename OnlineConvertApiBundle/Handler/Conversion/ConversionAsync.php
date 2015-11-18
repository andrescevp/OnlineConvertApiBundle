<?php

namespace Aacp\OnlineConvertApiBundle\Handler\Conversion;

use Qaamgo\Job\Interfaced;
use Qaamgo\Job\Sync;
use Qaamgo\Job\Async;
use Symfony\Component\Config\Loader\Loader;

class ConversionAsync
{
    public $category;

    public $target;

    /**
     * @var Sync|Async
     */
    public $jobCreator;

    private $loader;

    private $host;

    public function __construct(Interfaced $jobCreator, Loader $loader, $host)
    {
        $this->jobCreator = $jobCreator;
        $this->loader = $loader;
        $this->host = $host;
    }

    public function newJob($input, $options = []) {
        if (!$this->category || !$this->target) {
            throw new \RuntimeException('Category and Target are mandatory!');
        }

        $this->loader->load($this->category, $this->target);
        $callbackUri = $this->host . $this->loader->getRoute();
        return $this->jobCreator->createAsyncJob($this->category, $this->target, $input, $callbackUri, $options);
    }

}