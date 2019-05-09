<?php

/**
 * Customer Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "bi_view_customer",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * @Hateoas\Relation(
 *     "authenticated_user",
 *     embedded = @Hateoas\Embedded("expr(service('security.token_storage').getToken().getUser())"),
 * )
 * @UniqueEntity(fields="email", message="This email address is already in use !")
 */
class Customer
{
    /**
     * @var int
     * @access private
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="email", type="string", length=70, unique=true)
     * @Assert\NotBlank(message = "You must enter an email !")
     * @Assert\Length(
     *      min = 7,
     *      max = 70,
     *      minMessage = "The email must be at least 7 characters",
     *      maxMessage = "The email must be at most 70 characters"
     * )
     * @Assert\Email(message = "Please enter a valid email address !")
     * @Serializer\Expose
     */
    private $email;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="first_name", type="string", length=40)
     * @Assert\NotBlank(message = "You must enter an first name !")
     * @Assert\Length(
     *      min = 2,
     *      max = 40,
     *      minMessage = "The first name must be at least 2 characters",
     *      maxMessage = "The first name must be at least 40 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z]+-?[a-zA-Z]{1,}/",
     *      message = "The first name can only contain letters and a dash"
     * )
     * @Serializer\Expose
     */
    private $firstName;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="last_name", type="string", length=40)
     * @Assert\NotBlank(message = "You must enter an last name !")
     * @Assert\Length(
     *      min = 2,
     *      max = 40,
     *      minMessage = "The last name must be at least 2 characters",
     *      maxMessage = "The last name must be at least 40 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z]+-?[a-zA-Z]{1,}/",
     *      message = "The last name can only contain letters and a dash"
     * )
     * @Serializer\Expose
     */
    private $lastName;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="city", type="string", length=40)
     * @Assert\NotBlank(message = "You must enter an city !")
     * @Assert\Length(
     *      min = 1,
     *      max = 40,
     *      minMessage = "The city must be at least 1 character",
     *      maxMessage = "The city name must be at least 40 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z-]+$/",
     *      message = "The city can only contain letters and a dash"
     * )
     * @Serializer\Expose
     */
    private $city;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="country", type="string", length=20)
     * @Assert\NotBlank(message = "You must enter an country !")
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The country must be at least 4 characters",
     *      maxMessage = "The country name must be at least 20 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z]+-?[a-zA-Z]{1,}/",
     *      message = "The country can only contain letters and a dash"
     * )
     * @Serializer\Expose
     */
    private $country;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="adress", type="string", length=40)
     * @Assert\NotBlank(message = "You must enter an address !")
     * @Assert\Length(
     *      min = 5,
     *      max = 40,
     *      minMessage = "The address must be at least 5 characters",
     *      maxMessage = "The address must be at least 40 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z0-9 -]+$/",
     *      message = "The address can only contain letters, dashes, numbers, spaces"
     * )
     * @Serializer\Expose
     */
    private $address;

    /**
     * @var User
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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
     * Set email
     * @access public
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     * @access public
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     * @access public
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     * @access public
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     * @access public
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     * @access public
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set city
     * @access public
     * @param string $city
     *
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     * @access public
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     * @access public
     * @param string $country
     *
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     * @access public
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set address
     * @access public
     * @param string $address
     *
     * @return Customer
     */
    public function setAdress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     * @access public
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set user
     * @access public
     * @param User $user
     *
     * @return Customer
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     * @access public
     * 
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
