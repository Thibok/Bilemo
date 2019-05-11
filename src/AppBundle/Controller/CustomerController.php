<?php

/**
 * Customer Controller
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Exception\ResourceValidationException;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * CustomerController
 */
class CustomerController extends FOSRestController
{
    /**
     * @access public
     * @param Customer $customer
     * @param ConstraintViolationList $violations
     * @Rest\Post("/customers", name="bi_add_customer")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("customer", converter="fos_rest.request_body")
     * 
     * @return Customer
     */
    public function addAction(Customer $customer, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Validation errors: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $customer->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();

        $em->persist($customer);
        $em->flush();

        return $customer;
    }

    /**
     * @access public
     * @param Customer $customer
     * @Rest\View(StatusCode = 204)
     * @Rest\Delete(
     *     path = "/customers/{id}",
     *     name = "bi_delete_customer",
     *     requirements = {"id"="\d+"}
     * )
     * 
     * @return void
     */
    public function deleteAction(Customer $customer)
    {
        if ($customer->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('This resource is not accessible to you');
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($customer);
        $manager->flush();

        return;
    }

    /**
     * @access public
     * @Rest\Get(
     *     path = "/customers/{id}",
     *     name = "bi_view_customer",
     *     requirements = {"id"="\d+"}
     * )
     * 
     * @return Response
     */
    public function viewAction()
    {

    }
}