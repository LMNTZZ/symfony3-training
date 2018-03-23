<?php

namespace AppBundle\Service;

use AppBundle\Entity\BlogPost;
use AppBundle\Repository\BlogPostRepository;
use AppBundle\Service\Exception\ConnectivityException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class BlogPostServiceTest extends TestCase
{
    /**
     * @var EntityManagerInterface|ObjectProphecy
     */
    private $entityManager;

    /**
     * @var BlogPostService
     */
    private $blogPostService;

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
        $this->blogPostService = new BlogPostService($this->entityManager->reveal());
    }

    public function testFetchAllPosts()
    {
        $posts= [
            new BlogPost(),
            new BlogPost(),
        ];

        $this->repository->findAll()->willReturn($posts);
        $result = $this->blogPostService->fetchAllPosts();

        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);
        $this->assertSame($posts, $result);
    }

    public function testFetchAllPostsGoneWrong()
    {
        $this->setExpectedException(ConnectivityException::class);
        $this->repository->findAll()->willThrow(new DBALException('Test'));
        $this->blogPostService->fetchAllPosts();
    }
}