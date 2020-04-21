<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * CourierService
 *
 * @ORM\Table(name="courier_services")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\CourierServiceRepository")
 */
class CourierService
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
     * @ORM\Column(name="CourierServiceName", type="string", length=255, unique=true)
     */
    private $courierServiceName;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\DeliveryInfo", mappedBy="courierService")
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
     * Set courierServiceName.
     *
     * @param string $courierServiceName
     *
     * @return CourierService
     */
    public function setCourierServiceName($courierServiceName)
    {
        $this->courierServiceName = $courierServiceName;

        return $this;
    }

    /**
     * Get courierServiceName.
     *
     * @return string
     */
    public function getCourierServiceName()
    {
        return $this->courierServiceName;
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
     * @return CourierService
     */
    public function setAddresses(ArrayCollection $addresses): CourierService
    {
        $this->addresses = $addresses;

        return $this;
    }
}
