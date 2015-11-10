<?php

namespace Aacp\OnlineConvertApiBundle\Validator;


interface Interfaced
{
    /**
     * @param $data
     * @param $constraints
     * @return mixed
     */
    public function validate($data, $constraints);

}