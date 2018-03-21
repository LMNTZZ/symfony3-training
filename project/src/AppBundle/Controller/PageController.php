<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * @Route("/hobbies/", name="hobbypage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('page/page.html.twig', []);
    }

    /**
     * @Route("/hobbies/{hobby}", name="hobbyDetailPage")
     */
    public function switchPageAction(Request $request, $hobby)
    {
        // replace this example code with whatever you need
        return $this->render('page/'.$hobby.'.html.twig', []);
    }
}