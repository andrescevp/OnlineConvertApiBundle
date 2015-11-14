<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 13/11/2015
 * Time: 22:16
 */

namespace Aacp\DataCollector;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class Request extends DataCollector
{

    protected $data;

    /**
     * Collects data for the given Request and Response.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request A Request instance
     * @param Response $response A Response instance
     * @param \Exception $exception An Exception instance
     */
    public function collect(\Symfony\Component\HttpFoundation\Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'method' => $request->getMethod(),
            'acceptable_content_types' => $request->getAcceptableContentTypes(),
        );
    }

    public function getMethod()
    {
        return $this->data['method'];
    }

    public function getAcceptableContentTypes()
    {
        return $this->data['acceptable_content_types'];
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName()
    {
        return 'app.request_collector';
    }

}