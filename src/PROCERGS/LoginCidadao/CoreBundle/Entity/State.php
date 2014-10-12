<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * City
 *
 * @ORM\Table(name="state")
 * @ORM\Entity(repositoryClass="PROCERGS\LoginCidadao\CoreBundle\Entity\StateRepository")
 */
class State
{
    const REVIEWED_OK = 0;
    const REVIEWED_IGNORE = 1;

    /**
     * @Groups({"state", "rgs", "typeahead"})
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Groups({"state", "rgs", "typeahead"})
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"typeahead"})
     * @ORM\Column(name="acronym", type="string", length=2, nullable=true)
     */
    private $acronym;

    /**
     * @Groups({"state", "rgs"})
     * @ORM\Column(name="iso6", type="string", length=6, nullable=true)
     */
    private $iso6;

    /**
     * @Groups({"state", "rgs"})
     * @ORM\Column(name="fips", type="string", length=4, nullable=true)
     */
    private $fips;

    /**
     * @Groups({"state", "rgs"})
     * @ORM\Column(name="stat", type="string", length=7, nullable=true)
     */
    private $stat;

    /**
     * @Groups({"state", "rgs"})
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     */
    private $class;

    /**
     * @Groups({"typeahead"})
     * @ORM\ManyToOne(targetEntity="PROCERGS\LoginCidadao\CoreBundle\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $reviewed;
    
    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" = 0})
     * @var int
     */
    protected $preference;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($var)
    {
        $this->id = $var;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Acronym
     *
     * @param string $name
     * @return City
     */
    public function setAcronym($var)
    {
        $this->acronym = $var;

        return $this;
    }

    /**
     * Get Acronym
     *
     * @return string
     */
    public function getAcronym()
    {
        return $this->acronym;
    }

    public function setStat($var)
    {
        $this->stat = $var;

        return $this;
    }

    public function getStat()
    {
        return $this->stat;
    }

    public function setFips($var)
    {
        $this->fips = $var;

        return $this;
    }

    public function getFips()
    {
        return $this->fips;
    }

    public function setIso6($var)
    {
        $this->iso6 = $var;

        return $this;
    }

    public function getIso6()
    {
        return $this->iso6;
    }

    public function setReviewed($var)
    {
        $this->reviewed = $var;

        return $this;
    }

    public function getReviewed()
    {
        return $this->reviewed;
    }

    public function setCountry($var)
    {
        $this->country = $var;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

}
