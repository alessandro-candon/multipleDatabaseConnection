<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Repository\TaskRepository;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/database/{db}", name="db_selector")
     * @param $db
     * @return Response
     */
    public function selectAction($db)
    {
        $this->get('session')->set('db', $db);
        return new Response("Selected db $db", 200);
    }


    /**
     * @Route("/tasks", name="task", methods={"GET"} )
     * @return Response
     */
    public function getAllTaskAction()
    {
        /** @var Task[] $tasks */
        $tasks = $this->get('app.repository.task')->findAll();
        $tasks = $this->get('serializer')->normalize($tasks);

        return new JsonResponse($tasks);
    }
}
