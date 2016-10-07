<?php

namespace ArturAlves\EuroMillionsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $numbers = $em->getRepository('ArturAlvesEuroMillionsBundle:Number')->findAll();
        $stars = $em->getRepository('ArturAlvesEuroMillionsBundle:Star')->findAll();

        return $this->render('ArturAlvesEuroMillionsBundle:Dashboard:index.html.twig', array(
            'numbers' => $numbers,
            'stars' => $stars,
        ));
    }
}
