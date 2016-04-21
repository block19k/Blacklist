<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    /**
     * @Route("/requestCount", name="requestCount")
     * 
     */
    public function getRequestCount(){
        $em = $this->getDoctrine()->getManager();
        $links = $em->getRepository('AppBundle:Links')->findBy(
            array(
                'actionrequired' => true
            )
        );
        return count($links);
    }
}
