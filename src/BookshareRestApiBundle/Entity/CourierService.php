<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
