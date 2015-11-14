<?php

namespace Aacp\OnlineConvertApiBundle\EventListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Created by PhpStorm.
 * User: andres
 * Date: 13/11/2015
 * Time: 23:49
 */
class OnlineConvertRequest
{

    public function onKernelRequest(GetResponseEvent $event)
    {
        print_r($event);
   }

}