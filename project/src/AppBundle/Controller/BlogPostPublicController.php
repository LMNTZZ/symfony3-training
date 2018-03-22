<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Service\BlogPostService;
use AppBundle\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blogpost controller.
 *
 * @Route("blog")
 */
class BlogPostPublicController extends Controller
{
    private $blogPostService;
    private $commentService;

    public function __construct(BlogPostService $blogPostService, CommentService $commentService)
    {
        $this->blogPostService = $blogPostService;
        $this->commentService = $commentService;
    }

    /**
     * Lists all blogPost entities.
     *
     * @Route("/", name="blog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $blogPosts = $this->blogPostService->fetchAllPosts();

        return $this->render('blogpublic/index.html.twig', array(
            'blogPosts' => $blogPosts,
        ));
    }

    /**
     * Finds and displays a blogPost entity.
     *
     * @Route("/{id}", name="blog_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, BlogPost $blogPost)
    {
        $comment = new Comment();
        $comment->setBlogpost($blogPost);
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = $commentForm->getData();
            $this->commentService->persist($comment);

            return $this->redirectToRoute('blog_show', ['id' => $blogPost->getId()]);
        }

        return $this->render('blogpublic/show.html.twig', array(
            'blogPost' => $blogPost,
            'comments' => $blogPost->getComments(),
            'comment_form' => $commentForm->createView(),
        ));

    }

    public function recentpostsAction()
    {
        $blogPosts = $this->blogPostService->fetchRecentPosts();
        return $this->render('blogpublic/recentposts.html.twig', ['blogPosts' => $blogPosts]);
    }

}
