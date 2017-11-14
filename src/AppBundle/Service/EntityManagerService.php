<?php

namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Session\Session;

class EntityManagerService
{

    /** @var Registry $doctrineBundle */
    private $doctrine;

    /** @var  string $forcedDb */
    private $forcedDb;

    /** @var Session $session */
    private $session;

    public function __construct(Registry $doctrine, Session $session)
    {
        /** @var Registry doctrine */
        $this->doctrine = $doctrine;

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


    /**
     * @param string $force
     */
    public function forceDb($force)
    {
        $this->forcedDb = $force;
    }

}