<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use AppBundle\Service\BlogPostService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Blogpost controller.
 *
 * @Route("blog-admin")
 */
class BlogPostController extends Controller
{
    private $blogPostService;

    public function __construct(BlogPostService $blogPostService)
    {
        $this->blogPostService = $blogPostService;
    }

    /**
     * Lists all blogPost entities.
     *
     * @Route("/", name="blog_admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $blogPosts = $this->blogPostService->fetchAllPosts();

        return $this->render('blogpost/index.html.twig', array(
            'blogPosts' => $blogPosts,
        ));
    }

    /**
     * Creates a new blogPost entity.
     *
     * @Route("/new", name="blog_admin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blogPost = new Blogpost();
        $form = $this->createForm('AppBundle\Form\BlogPostType', $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->blogPostService->persist($blogPost);

            return $this->redirectToRoute('blog_admin_show', array('id' => $blogPost->getId()));
        }

        return $this->render('blogpost/new.html.twig', array(
            'blogPost' => $blogPost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blogPost entity.
     *
     * @Route("/{id}", name="blog_admin_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, BlogPost $blogPost)
    {
        $deleteForm = $this->createDeleteForm($blogPost);

        return $this->render('blogpost/show.html.twig', array(
            'blogPost' => $blogPost,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blogPost entity.
     *
     * @Route("/{id}/edit", name="blog_admin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlogPost $blogPost)
    {
        $deleteForm = $this->createDeleteForm($blogPost);
        $editForm = $this->createForm('AppBundle\Form\BlogPostType', $blogPost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_admin_edit', array('id' => $blogPost->getId()));
        }

        return $this->render('blogpost/edit.html.twig', array(
            'blogPost' => $blogPost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blogPost entity.
     *
     * @Route("/{id}", name="blog_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlogPost $blogPost)
    {
        $form = $this->createDeleteForm($blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogPost);
            $em->flush();
        }

        return $this->redirectToRoute('blog_admin_index');
    }

    /**
     * Creates a form to delete a blogPost entity.
     *
     * @param BlogPost $blogPost The blogPost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogPost $blogPost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_admin_delete', array('id' => $blogPost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
