<?php

namespace AppBundle\Controller;

use JMS\Serializer\Serializer;
use AppBundle\Representation\Phones;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhoneController extends FOSRestController
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

    /**
     * @Rest\Get("/phones", name="bi_list_phones")
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="^[1-9]+[0-9]*",
     *     default="5",
     *     description="Max number of phones per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="^[1-9]+[0-9]*",
     *     default="1",
     *     description="The current page"
     * )
     * @Rest\View()
     */
    public function listAction(ParamFetcher $paramFetcher, SerializerInterface $serializer)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Phone')->getPhones(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );

        $phones = new Phones($pager);

        $body = $serializer->serialize($phones, 'json');

        return new Response($body);
    }
}