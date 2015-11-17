<?php

namespace Aacp\OnlineConvertApiBundle\Handler;

use Qaamgo\JobCreator;

class Conversion
{
    private $jobCreator;

    public function __construct(JobCreator $jobCreator)
    {
        $this->jobCreator = $jobCreator;
    }

    public function createJob($category, $target, $input, $options = [])
    {
        $this->jobCreator->createJob($category, $target, $input, $options);
    }
}