<?php

namespace AppBundle\Controller;

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
    public function indexAction($db)
    {
        $this->get('session')->set('db', $db);
        return new Response("Selected db $db", 200);
    }
}
