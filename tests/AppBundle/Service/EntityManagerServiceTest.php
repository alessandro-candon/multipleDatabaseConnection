<?php

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
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



}