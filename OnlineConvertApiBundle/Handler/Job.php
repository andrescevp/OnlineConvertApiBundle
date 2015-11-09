<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 05/11/2015
 * Time: 23:29
 */

namespace Aacp\OnlineConvertApiBundle\Handler;


use SwaggerClient\JobsApi;
use SwaggerClient\models\Conversion;
use SwaggerClient\models\InputFile;
use SwaggerClient\models\Job as SdkModelJob;
class Job
{
    private $job;

    private  $apiKey;

    private $conversion;

    private $inputFile;

    private $jobApi;

    private $createdJob;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->job = new SdkModelJob();
        $this->conversion = new Conversion();
        $this->inputFile = new InputFile();
        $this->jobApi = new JobsApi();
    }

    public function createNewJob()
    {
        
    }
}