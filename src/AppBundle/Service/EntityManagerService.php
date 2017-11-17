<?php

namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class EntityManagerService
{

    /** @var Registry $doctrineBundle */
    private $doctrine;

    /** @var Session $session */
    private $session;

    /**
     * EntityManagerService constructor.
     * @param Registry $doctrine
     * @param Session $session
     */
    public function __construct(Registry $doctrine, Session $session)
    {
        /** @var Registry doctrine */
        $this->doctrine = $doctrine;

        /** @var Session session */
        $this->session = $session;
    }

    /**
     * @return object
     */
    public function getEntityManager()
    {
        /** @var string $dbName */
        $dbName = $this->getDatabaseName();
        return $this->doctrine->getManager($dbName);
    }

    /**
     * @param $repository
     * @return ObjectRepository|ObjectRepository
     */
    public function getRepository($repository)
    {
        return $this->getEntityManager()->getRepository($repository);
    }


    /**
     * @return string
     */
    public function getDatabaseName()
    {
        if (
            $this->session &&
            $this->session->has('db') &&
            array_key_exists(
                $this->session->get('db'),
                $this->doctrine->getConnectionNames()
            )
        ) {
            return $this->session->get('db');
        }
        return null;
    }
//
//
//    /**
//     * @param string $force
//     */
//    public function forceDb($force)
//    {
//        $this->forcedDb = $force;
//    }

}