<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 10/11/2015
 * Time: 20:53
 */

namespace Aacp\OnlineConvertApiBundle\Handler;


class AllConversions extends Conversion
{



    public function newConversion($input, $category, $target, $options = '') {
        $this->category = $category;
        $this->target = $target;

        parent::createNewConversion($input, $options);
    }

    protected function dispatch($pretty = false)
    {
        // TODO: Implement dispatch() method.
    }
}