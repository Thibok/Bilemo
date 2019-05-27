<?php

/**
 * AbstractProduct
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * AbstractProduct
 * @Serializer\ExclusionPolicy("all")
 */
abstract class AbstractProduct
{
    /**
     * @var int
     * @access protected
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    protected $id;

    /**
     * @var string
     * @access protected
     * @ORM\Column(name="brand", type="string", length=50)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    protected $brand;

    /**
     * @var string
     * @access protected
     * @ORM\Column(name="price", type="decimal", precision=6, scale=2)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    protected $price;

    /**
     * @var string
     * @access protected
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    protected $description;

    /**
     * Get id
     * @access public
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set brand
     * @access public
     * @param string $brand
     *
     * @return Phone
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     * @access public
     * 
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set price
     * @access public
     * @param string $price
     *
     * @return Phone
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     * @access public
     * 
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     * @access public
     * @param string $description
     *
     * @return Phone
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     * @access public
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}