<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientSpaceController extends Controller
{
    /**
     * @Route("/space", name="bi_space")
     */
    public function spaceAction()
    {
        return new Response('ok');
    }
}