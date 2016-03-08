<?php

namespace AA\EuromilhoesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AAEuromilhoesBundle:Default:index.html.twig', array('name' => $name));
    }
}
