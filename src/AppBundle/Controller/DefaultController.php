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

//    /**
//     * @Route("/tasks", name="task", methods={"GET"} )
//     * @return Response
//     */
//    public function getAllTaskAction()
//    {
//        /** @var TaskRepository $taskRepository */
//        $taskRepository = $this
//            ->get('entity.manager.service')
//            ->getRepository(Task::class);
//
//        /** @var Task[] $tasks */
//        $tasks = $taskRepository->findAll();
//        $tasks = $this->get('serializer')->normalize($tasks);
//
//        return new JsonResponse($tasks);
//    }

//    /**
//     * @Route("/tasks", name="task", methods={"GET"} )
//     * @return Response
//     */
//    public function getAllTaskAction()
//    {
//        /** @var EntityManager $db */
//        $entityManager = $this->get('entity.manager.service')
//            ->getEntityManager();
//
//        /** @var TaskRepository $taskRepository */
//        $taskRepository = $entityManager
//            ->getRepository(Task::class);
//
//        /** @var Task[] $tasks */
//        $tasks = $taskRepository->findAll();
//        $tasks = $this->get('serializer')->normalize($tasks);
//
//        return new JsonResponse($tasks);
//    }

//    /**
//     * @Route("/tasks", name="task", methods={"GET"} )
//     * @return Response
//     */
//    public function getAllTaskAction()
//    {
//        $db = null;
//        if (array_key_exists(
//            $this->get('session')->get('db'),
//            $this->getDoctrine()->getConnectionNames())
//        ) {
//            $db = $this->get('session')->get('db');
//        }
//
//        /** @var TaskRepository $taskRepository */
//        $taskRepository = $this->get('doctrine')
//            ->getManager($db)
//            ->getRepository(Task::class);
//
//        /** @var Task[] $tasks */
//        $tasks = $taskRepository->findAll();
//        $tasks = $this->get('serializer')->normalize($tasks);
//
//        return new JsonResponse($tasks);
//    }

}
