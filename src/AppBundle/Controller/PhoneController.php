<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use JMS\Serializer\Serializer;
use AppBundle\Representation\Phones;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhoneController extends FOSRestController
{
    /**
     * @access public
     * @param Phone $phone
     * @param Serializer $serializer
     * @Rest\Get(
     *     path = "/phones/{id}",
     *     name = "bi_view_phone",
     *     requirements = {"id"="\d+"}
     * )
     * 
     * @return Response
     */
    public function viewAction(Phone $phone, Serializer $serializer)
    {
        $body = $serializer->serialize($phone, 'json');

        $response = new Response($body);

        $response->setSharedMaxAge(3600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @access public
     * @param ParamFetcher $paramFetcher
     * @param Serializer $serializer
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
     * 
     * @return Response
     */
    public function listAction(ParamFetcher $paramFetcher, Serializer $serializer)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Phone')->getPhones(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );

        $phones = new Phones($pager);
        $body = $serializer->serialize($phones, 'json');

        $response = new Response($body);

        $response->setSharedMaxAge(3600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}