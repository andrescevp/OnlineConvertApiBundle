<?php

namespace Aacp\OnlineConvertApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AacpOnlineConvertApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
