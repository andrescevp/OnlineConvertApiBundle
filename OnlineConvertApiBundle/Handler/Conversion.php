<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 05/11/2015
 * Time: 23:28
 */

namespace Aacp\OnlineConvertApiBundle\Handler;


use Aacp\OnlineConvertApiBundle\Decorator\Factory as FactoryDecorator;
use SwaggerClient\JobsApi;
use SwaggerClient\models\Conversion as SdkModelConversion;
use SwaggerClient\models\InputFile;
use SwaggerClient\models\Job as SdkModelJob;
use SwaggerClient\OutputApi;

class Conversion
{
    private $job;

    private $apiKey;

    private $conversion;

    private $inputFiles;

    private $jobApi;

    private $createdJob;

    const INPUT_REMOTE = 'remote';

    const INPUT_UPLOAD = 'upload';

    private $decorator;

    private $https;

    public function __construct($apiKey, $decoratorName, $https = false)
    {
        $this->apiKey = $apiKey;
        $this->job = new SdkModelJob();
        $this->conversion = new SdkModelConversion();
        $this->jobApi = new JobsApi();
        $decoratorFactory = new FactoryDecorator($decoratorName);
        $this->decorator = $decoratorFactory->getDecorator();
        $this->https = $https;
    }

    public function createNewConversion($category, $target, $input)
    {
        $this->conversion->category = $category;
        $this->conversion->target = $target;

        $inputFile = new InputFile();
        $inputFile->source = $input;
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            $inputFile->type = self::INPUT_REMOTE;
            $this->job->input[] = $inputFile;
        } else {
            $inputFile->type = self::INPUT_UPLOAD;
            $this->inputFiles = $inputFile;
        }

        $this->createJob();

        return $this->decorator->pretty($this->createdJob);
    }

    public function getJobInfo($jobId)
    {
        return $this->decorator->pretty(
            $this->jobApi->jobsJobIdGet(null, $this->apiKey, $jobId)
        );

    }

    public function getOutput($jobId)
    {
        $output = new OutputApi();
        $output = $output->jobsJobIdOutputGet(
            null,
            null,
            null,
            $this->apiKey,
            $jobId
        );

        return $output;
    }

    private function createJob()
    {
        $this->job->conversion[] = $this->conversion;
        //Expected all the inputs with the same type
        $this->createdJob = $this->jobApi->jobsPost($this->apiKey, $this->job);

        if (is_object($this->inputFiles) && $this->inputFiles->type === self::INPUT_UPLOAD) {
            $this->prepareServerUrl();
            $this->createdJob = $this->jobApi->jobsPostFile(
                $this->apiKey,
                $this->createdJob,
                $this->inputFiles->source
            );
        }
    }

    private function prepareServerUrl()
    {
        if (!$this->https) {
            $this->createdJob->server = preg_replace("/^https:/i", "http:", $this->createdJob->server);
        }
    }

}