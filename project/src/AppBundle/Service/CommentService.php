<?php

namespace AppBundle\Service;

use AppBundle\Entity\Comment;
use AppBundle\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class CommentService
{
    /**
     * @var CommentRepository
     */
    protected $repository;
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('AppBundle:Comment');
        $this->entityManager = $entityManager;
    }

    public function persist(Comment $comment)
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}