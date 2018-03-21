<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Blogpost controller.
 *
 * @Route("blog")
 */
class BlogPostPublicController extends Controller
{
    /**
     * Lists all blogPost entities.
     *
     * @Route("/", name="blog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogPosts = $em->getRepository('AppBundle:BlogPost')->findAll();

        return $this->render('blogpublic/index.html.twig', array(
            'blogPosts' => $blogPosts,
        ));
    }

    /**
     * Finds and displays a blogPost entity.
     *
     * @Route("/{id}", name="blog_show")
     * @Method("GET")
     */
    public function showAction(BlogPost $blogPost)
    {

        return $this->render('blogpublic/show.html.twig', array(
            'blogPost' => $blogPost,
        ));
    }

}
