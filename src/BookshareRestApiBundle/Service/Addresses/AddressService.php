<?php


namespace BookshareRestApiBundle\Service\Addresses;


use BookshareRestApiBundle\Repository\CourierServiceRepository;

class AddressService implements AddressServiceInterface
{
    private $courierServiceRepository;

    public function __construct(CourierServiceRepository $courierServiceRepository)
    {
        $this->courierServiceRepository = $courierServiceRepository;
    }

    public function getAllCourierServices(): array
    {
        return $this->courierServiceRepository->findAll();
    }
}