<?php

namespace Aacp\OnlineConvertApiBundle\Handler;

/**
 * Class BaseConversion
 * @package Aacp\OnlineConvertApiBundle\Handler
 * @author Andrés Cevallos <a.cevallos@qaamgo.com>
 */
class BaseConversion extends Conversion
{
    private $category;

    private $target;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function newJob($input, $options = []) {
        $this->jobCreator->createJob($this->category, $this->target, $input, $options);
    }

}
