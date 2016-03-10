<?php

namespace AA\EuroMillionsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AAEuroMillionsBundle:Default:index.html.twig', array('name' => $name));
    }
}
