<?php

namespace AppBundle\Entity;

use AppBundle\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class BlogPostTest extends TestCase
{
    /**
     * @var EntityManagerInterface|ObjectProphecy
     */
    private $entityManager;

    /**
     * @var BlogPost
     */
    private $blogPost;

    /**
     * @var BlogPostRepository|ObjectProphecy
     */
    private $repository;

    public function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->repository = $this->prophesize(BlogPostRepository::class);
        $this->entityManager->getRepository(Argument::exact('AppBundle:BlogPost'))
            ->willReturn($this->repository->reveal());
        $this->blogPost = new BlogPost($this->entityManager->reveal());
    }
}