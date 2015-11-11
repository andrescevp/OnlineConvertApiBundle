<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 12/11/2015
 * Time: 0:30
 */

namespace Aacp\OnlineConvertApiBundle\Handler\Schema;


interface PersisterInterface
{
    public function getSchema($name, $data);
}