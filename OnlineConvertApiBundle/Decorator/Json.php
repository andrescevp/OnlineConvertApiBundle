<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 06/11/2015
 * Time: 0:46
 */

namespace Aacp\OnlineConvertApiBundle\Decorator;


class Json implements  Interfaced
{

    public function pretty($input)
    {

        if (is_object($input)) {
            $input = get_object_vars($input);
        }

        return json_encode($input);
    }
}