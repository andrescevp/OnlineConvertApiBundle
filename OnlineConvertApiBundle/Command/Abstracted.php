<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 05/11/2015
 * Time: 23:49
 */

namespace Aacp\OnlineConvertApiBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class Abstracted extends ContainerAwareCommand
{
    protected $container;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    private function init()
    {
        $this->container = $this->getContainer();
    }
}