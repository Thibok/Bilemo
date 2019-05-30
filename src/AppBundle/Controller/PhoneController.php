<?php

/**
 * PhoneController
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Phone;
use AppBundle\Representation\Phones;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * PhoneController
 */
class PhoneController extends FOSRestController
{
    /**
     * View phone details
     * @access public
     * @param Phone $phone
     * @param Serializer $serializer
     * @Rest\Get(
     *     path="/phones/{id}",
     *     name="bi_view_phone",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     * 
     * @return Phone
     */
    public function viewAction(Phone $phone)
    {
        return $phone;
    }

    /**
     * Get list of phones
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
     * @Rest\View()
     * 
     * @return Response
     */
    public function listAction(ParamFetcher $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Phone')->getPhones(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );

        return new Phones($pager);
    }
}