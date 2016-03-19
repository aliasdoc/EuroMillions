<?php

namespace ArturAlves\EuroMillionsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $draws = $em->getRepository('ArturAlvesEuroMillionsBundle:Draw')->findAll();

        return $this->render('ArturAlvesEuroMillionsBundle:Dashboard:index.html.twig', array(
            'draws' => $draws,
        ));
    }
}
