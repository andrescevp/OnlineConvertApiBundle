<?php

namespace Aacp\OnlineConvertApiBundle\Handler\Conversion;

use Qaamgo\Job\Interfaced;
use Qaamgo\Job\Sync;
use Qaamgo\Job\Async;

class ConversionSync
{
    public $category;

    public $target;

    /**
     * @var Sync|Async
     */
    public $jobCreator;

    public function __construct(Interfaced $jobCreator)
    {
        $this->jobCreator = $jobCreator;
    }

    public function newJob($input, $options = []) {
        if (!$this->category || !$this->target) {
            throw new \RuntimeException('Category and Target are mandatory!');
        }

        return $this->jobCreator->createSyncJob($this->category, $this->target, $input, $options);
    }

}