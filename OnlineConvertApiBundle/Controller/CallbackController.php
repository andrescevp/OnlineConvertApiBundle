<?php

namespace Aacp\OnlineConvertApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CallbackController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function endPointAction()
    {
        return new Response('ok', 200);
    }
}
