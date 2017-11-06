<?php

namespace AppBundle\Service;


use AppBundle\Entity\Task;
use AppBundle\Repository\TaskRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class EntityManagerServiceTest extends WebTestCase
{

    /** @var  ContainerInterface $container */
    public static $container;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        self::$container = $kernel->getContainer();
    }

    /**
     * @dataProvider getDatabaseNameDataProvider
     * @param $db
     * @param $expected
     */
    public function testGetDatabaseName($db, $expected)
    {
        $session = new Session(new MockArraySessionStorage());
        $session->set('db', $db);

        $entityManagerService = new EntityManagerService(
            self::$container->get('doctrine'),
            $session
        );

        $this->assertEquals($expected, $entityManagerService->getDatabaseName());
    }

    public function getDatabaseNameDataProvider(){
        return [
            [
                'dbone',
                'dbone'
            ],
            [
                'dbtwo',
                'dbtwo'
            ],
            [
                'dbthatdontexist',
                null
            ]
        ];
    }


    /**
     * @dataProvider getEntityManagerDataProvider
     * @param $db
     * @param $expected
     */
    public function testGetEntityManager($db, $expected)
    {

        $session = new Session(new MockArraySessionStorage());
        $session->set('db', $db);

        $entityManagerService = new EntityManagerService(
            self::$container->get('doctrine'),
            $session
        );

        $this->assertInstanceOf(EntityManager::class, $entityManagerService->getEntityManager());
        $this->assertEquals($expected, $entityManagerService->getEntityManager()->getConnection()->getDatabase());
    }

    public function getEntityManagerDataProvider(){
        return [
            [
                'dbone',
                'dbone'
            ],
            [
                'dbtwo',
                'dbtwo'
            ],
            [
                'dbthatdontexist',
                'dbone'
            ]
        ];
    }

    /**
     * @dataProvider getRepositoryDataProvider
     * @param $db
     * @param $expected
     */
    public function testGetRepository($db, $expected)
    {

        $session = new Session(new MockArraySessionStorage());
        $session->set('db', $db);

        $entityManagerService = new EntityManagerService(
            self::$container->get('doctrine'),
            $session
        );

        $this->assertInstanceOf(
            TaskRepository::class,
            $entityManagerService->getRepository(Task::class)
        );
        $this->assertEquals(
            Task::class,
            $entityManagerService->getRepository(Task::class)->getClassName()
        );
    }

    public function getRepositoryDataProvider(){
        return [
            [
                'dbone',
                'dbone'
            ],
            [
                'dbtwo',
                'dbtwo'
            ],
            [
                'dbthatdontexist',
                'dbone'
            ]
        ];
    }

}