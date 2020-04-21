<?php

namespace BookshareRestApiBundle\Entity;

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
}
