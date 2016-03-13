<?php

namespace AA\EuroMillionsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $draws = $em->getRepository('AAEuroMillionsBundle:Draw')->findAll();

        return $this->render('AAEuroMillionsBundle:Dashboard:index.html.twig', array(
            'draws' => $draws,
        ));
    }
}
