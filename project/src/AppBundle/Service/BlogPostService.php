<?php

namespace AppBundle\Service;

use AppBundle\Entity\BlogPost;
use AppBundle\Repository\BlogPostRepository;
use AppBundle\Service\Exception\ConnectivityException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

class BlogPostService
{
    /**
     * @var BlogPostRepository
     */
    protected $repository;
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('AppBundle:BlogPost');
        $this->entityManager = $entityManager;
    }

    public function fetchAllPosts()
    {
        try {
            return $this->repository->findAll();
        } catch (DBALException $e) {
            throw new ConnectivityException($e->getMessage());
        }
    }

    public function fetchRecentPosts()
    {
        return $this->repository->findBy([], [], 5, 0);
    }

    public function persist(BlogPost $blogPost)
    {
        $this->entityManager->persist($blogPost);
        $this->entityManager->flush();
    }
}