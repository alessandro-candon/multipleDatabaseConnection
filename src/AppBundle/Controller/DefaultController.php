<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("/task", name="db_selector")
     * @param $db
     * @return Response
     */
    public function Action($db)
    {
        $this->get('entity.manager.service')->getRepository(Task::class);
        return new Response("Selected db $db", 200);
    }
}
