<?php

/**
 * Controller for client space
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ClientSpaceController
 */
class ClientSpaceController extends Controller
{
    /**
     * Client space
     * @access public
     * @Route("/space", name="bi_space")
     * 
     * @return Response
     */
    public function spaceAction()
    {
        return new Response('ok');
    }
}