<?php

/**
 * Phone Entity
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AbstractProduct;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Phone
 *
 * @ORM\Table(name="phone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhoneRepository")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "bi_view_phone",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * @Hateoas\Relation(
 *     "authenticated_user",
 *     embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 *     exclusion = @Hateoas\Exclusion(
 *         excludeIf = "expr(service('request_stack').getCurrentRequest().get('_route') == 'bi_list_phones')"
 *     )
 * )
 */
class Phone extends AbstractProduct
{
    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=20)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="memory", type="integer")
     */
    private $memory;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=20)
     */
    private $color;

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Phone
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set memory
     *
     * @param integer $memory
     *
     * @return Phone
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get memory
     *
     * @return int
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Phone
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}

