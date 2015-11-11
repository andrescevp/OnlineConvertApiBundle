<?php

namespace Aacp\OnlineConvertApiBundle\Handler;


use Aacp\OnlineConvertApiBundle\Decorator\Factory as FactoryDecorator;
use Aacp\OnlineConvertApiBundle\Handler\Schema\Persister;
use Aacp\OnlineConvertApiBundle\Helper\Common;
use Aacp\OnlineConvertApiBundle\Helper\Constants;
use Aacp\OnlineConvertApiBundle\Validator\ConversionOptions;
use SwaggerClient\JobsApi;
use SwaggerClient\models\Conversion as SdkModelConversion;
use SwaggerClient\models\InputFile;
use SwaggerClient\models\Job as SdkModelJob;
use SwaggerClient\models\Status;
use SwaggerClient\OutputApi;

abstract class Conversion
{
    /**
     * @var SdkModelJob
     */
    protected $job;

    /**
     * @var string The API KEY from online-convert.com
     */
    protected $apiKey;

    /**
     * @var SdkModelConversion
     */
    protected $conversion;

    /**
     * @var InputFile[]
     */
    protected $inputFiles;

    /**
     * @var JobsApi
     */
    protected $jobApi;

    /**
     * @var SdkModelJob
     */
    protected $createdJob;

    /**
     * @var \Aacp\OnlineConvertApiBundle\Decorator\Interfaced
     */
    protected $decorator;

    /**
     * @var bool For enable/disabled the https on uploads
     */
    protected $https;

    protected $category;

    protected $target;

    private $information;
    private $schemaPersister;

    public function __construct($apiKey, Information $information, $decoratorName, $category = null, $target = null, $https = false)
    {
        $this->apiKey = $apiKey;
        $this->job = new SdkModelJob();
        $this->conversion = new SdkModelConversion();
        $this->jobApi = new JobsApi();
        $decoratorFactory = new FactoryDecorator($decoratorName);
        $this->decorator = $decoratorFactory->getDecorator();
        $this->information = $information;
        $this->https = $https;
        $this->category = $category;
        $this->target = $target;
        $this->schemaPersister = new Persister();
    }

    /**
     * Create a new conversion
     *
     * @param $category
     * @param $target
     * @param $input
     * @return mixed
     */
    public function createNewConversion($input, $options = '')
    {
        $this->conversion->category = $this->category;
        $this->conversion->target = $this->target;

        $inputFile = new InputFile();
        $inputFile->source = $input;
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            $inputFile->type = Constants::INPUT_REMOTE;
            $this->job->input[] = $inputFile;
        } else {
            $inputFile->type = Constants::INPUT_UPLOAD;
            $this->inputFiles[0] = $inputFile;
        }

        if(!empty($options)) {
            $validator = new ConversionOptions();
            $schema = $this->information->getConversionInfo($this->category, $this->target, 1);
            $schema = substr($schema, 1, -1);
            $schema = $this->schemaPersister->getSchema($this->category . '.' .$this->target, $schema);
            $validator->validate($options, $schema);
        }

        $this->createJob();

        return $this->getJobInfo($this->createdJob->id);
    }

    /**
     * @param $jobId
     * @return mixed
     */
    public function getJobInfo($jobId)
    {
        return $this->jobApi->jobsJobIdGet($this->apiKey, $jobId);

    }

    /**
     * @param $jobId
     * @return array|OutputApi
     */
    public function getOutput($jobId)
    {
        $output = new OutputApi();
        $output = $output->jobsJobIdOutputGet(
            $this->apiKey,
            $jobId
        );

        return $output;
    }

    /**
     * Create a job and post the file if is needed
     */
    protected function createJob()
    {
        $this->job->conversion[] = $this->conversion;
        //Expected all the inputs with the same type
        $this->createdJob = $this->jobApi->jobsPost($this->apiKey, $this->job);

        $this->postFile($this->inputFiles[0]);
    }

    /**
     * @param InputFile $file
     * @return bool
     */
    protected function postFile(InputFile $file)
    {
        if (is_object($file) && $file->type === Constants::INPUT_UPLOAD) {
            $this->createdJob->server = Common::httpsToHttpVice($this->createdJob->server);
            $this->createdJob->input[] = $this->jobApi->jobsPostFile(
                $this->apiKey,
                $this->createdJob,
                $file->source
            );
        }

        return true;
    }

    /**
     * @param \Aacp\OnlineConvertApiBundle\Decorator\Interfaced $decorator
     */
    public function setDecorator($decorator)
    {
        $this->decorator = $decorator;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return SdkModelJob
     */
    public function getCreatedJob()
    {
        return $this->createdJob;
    }

    /**
     * Call the job for check the status is completed
     *
     * @return Status|String|Array
     */
    public function lookStatus()
    {
        /** @var Status $status */
        $status = new Status();
        while ($status->code != Constants::STATUS_COMPLETED) {
            $status = $this->getStatus();
            if ($status->code == Constants::STATUS_FAILED) {
                throw new ConversionException('Job Status: ' . Constants::STATUS_FAILED . 'Message: ' . $status->info);
            }
            if ($status->code == Constants::STATUS_INVALID) {
                throw new ConversionException('Job Status: ' . Constants::STATUS_INVALID . 'Message: ' . $status->info);
            }
            if ($status->code == Constants::STATUS_INCOMPLETE) {
                throw new ConversionException('Job Status: ' . Constants::STATUS_INCOMPLETE . 'Message: ' . $status->info );
            }
        }

        return $status;
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->jobApi->jobsJobIdGet($this->apiKey, $this->createdJob->id)->status;
    }

    /**
     * @return \Aacp\OnlineConvertApiBundle\Decorator\Interfaced
     */
    public function getDecorator()
    {
        return $this->decorator;
    }



    /**
     * Use this method to add yourself events when look the status of the Job
     *
     * @return mixed
     */
    protected function dispatch(){
        //TODO implement with a logger, or some entry in your data base
    }

}