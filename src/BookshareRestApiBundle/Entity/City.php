<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Cities
 *
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\CityRepository")
 */
class City
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cityName", type="string", length=255, unique=false)
     */
    private $cityName;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\DeliveryInfo", mappedBy="city")
     */
    private $addresses;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cityName.
     *
     * @param string $cityName
     *
     * @return City
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName.
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param ArrayCollection $addresses
     * @return City
     */
    public function setAddresses(ArrayCollection $addresses): City
    {
        $this->addresses = $addresses;

        return $this;
    }
}
