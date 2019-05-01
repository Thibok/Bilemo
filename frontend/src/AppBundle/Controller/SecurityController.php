<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/", name="bi_login")
     */
    public function loginAction(Request $request)
    {
        return $this->render('security/login.html.twig');
    }
}
