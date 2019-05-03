<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhoneController extends Controller
{
    /**
     * @Rest\Get(
     *     path = "/phones/{id}",
     *     name = "bi_view_phone",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function viewAction()
    {
        return new Response('ok');
    }
}