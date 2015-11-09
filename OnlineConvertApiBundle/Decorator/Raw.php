<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 05/11/2015
 * Time: 23:55
 */

namespace Aacp\OnlineConvertApiBundle\Decorator;


class Raw implements Interfaced
{

    public function pretty($input)
    {
        return print_r($input);
    }
}