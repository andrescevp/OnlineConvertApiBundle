<?php

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