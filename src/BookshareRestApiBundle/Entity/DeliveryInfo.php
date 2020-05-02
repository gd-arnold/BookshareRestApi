<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DeliveryInfo
 *
 * @ORM\Table(name="delivery_info")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\DeliveryInfoRepository")
 */
class DeliveryInfo
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
     * @var CourierService
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\CourierService", inversedBy="addresses")
     * @ORM\JoinColumn(name="courier_service_id", referencedColumnName="id")
     */
    private $courierService;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\City", inversedBy="addresses")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="BookshareRestApiBundle\Entity\User", mappedBy="addresses")
     */
    private $users;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\BookRequest", mappedBy="requesterAddress")
     */
    private $userRequests;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\BookRequest", mappedBy="receiverAddress")
     */
    private $userReceives;

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
     * Set address.
     *
     * @param string $address
     *
     * @return DeliveryInfo
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return CourierService
     */
    public function getCourierService(): CourierService
    {
        return $this->courierService;
    }

    /**
     * @param CourierService $courierService
     * @return DeliveryInfo
     */
    public function setCourierService(CourierService $courierService): DeliveryInfo
    {
        $this->courierService = $courierService;

        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return DeliveryInfo
     */
    public function setCity(City $city): DeliveryInfo
    {
        $this->city = $city;

        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     *
     * @return DeliveryInfo
     */
    public function setUsers(ArrayCollection $users): DeliveryInfo
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserRequests(): ArrayCollection
    {
        return $this->userRequests;
    }

    /**
     * @param ArrayCollection $userRequests
     * @return DeliveryInfo
     */
    public function setUserRequests(ArrayCollection $userRequests): DeliveryInfo
    {
        $this->userRequests = $userRequests;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserReceives(): ArrayCollection
    {
        return $this->userReceives;
    }

    /**
     * @param ArrayCollection $userReceives
     * @return DeliveryInfo
     */
    public function setUserReceives(ArrayCollection $userReceives): DeliveryInfo
    {
        $this->userReceives = $userReceives;

        return $this;
    }
}
