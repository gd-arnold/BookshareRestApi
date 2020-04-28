<?php


namespace BookshareRestApiBundle\Service\Addresses;


use BookshareRestApiBundle\Entity\City;
use BookshareRestApiBundle\Entity\CourierService;
use BookshareRestApiBundle\Repository\CityRepository;
use BookshareRestApiBundle\Repository\CourierServiceRepository;
use BookshareRestApiBundle\Repository\DeliveryInfoRepository;

class AddressService implements AddressServiceInterface
{
    private $deliveryInfoRepository;
    private $courierServiceRepository;

    public function __construct(
        DeliveryInfoRepository $deliveryInfoRepository,
        CourierServiceRepository $courierServiceRepository
    )
    {
        $this->deliveryInfoRepository = $deliveryInfoRepository;
        $this->courierServiceRepository = $courierServiceRepository;
    }

    public function getAllCourierServices(): array
    {
        return $this->courierServiceRepository->findAll();
    }

    public function getAllCitiesByCourierService(CourierService $courierService): array
    {
        return $this->deliveryInfoRepository->findAllCitiesByCourierService($courierService);
    }

    /**
     * @param int $id
     * @return CourierService|object
     */
    public function courierServiceById(int $id): CourierService
    {
        return $this->courierServiceRepository->find($id);
    }

    public function getAllAddressesByCityAndCourier(City $city, CourierService $courier): array
    {
        return $this->deliveryInfoRepository->findAllAddressesByCityAndCourier($city, $courier);
    }
}