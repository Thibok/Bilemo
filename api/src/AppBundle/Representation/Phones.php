<?php

/**
 * Phones Representation
 */

namespace AppBundle\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Phones
 * @Hateoas\Relation(
 *     "authenticated_user",
 *     embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())")
 * )
 */
class Phones
{
    /**
     * @var array
     * @access private
     * @Type("array<AppBundle\Entity\Phone>")
     */
    public $data;

    /**
     * @var array
     * @access private
     */
    public $meta;

    /**
     * Constructor
     * @access public
     * @param Pagerfanta $data
     * 
     * @return void
     */
    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('page', $data->getCurrentPage());
    }

    /**
     * Add meta
     * @access public
     * @param string $name
     * @param mixed $value
     * 
     * @return void
     */
    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exist', $name));
        }

        $this->setMeta($name, $value);
    }

    /**
     * Set meta
     * @access public
     * @param string $name
     * @param mixed $value
     * 
     * @return void
     */
    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}