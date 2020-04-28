<?php


namespace BookshareRestApiBundle\Service\Addresses;


use BookshareRestApiBundle\Entity\City;
use BookshareRestApiBundle\Entity\CourierService;
use BookshareRestApiBundle\Entity\DeliveryInfo;

interface AddressServiceInterface
{
    public function getAllCourierServices(): array;
    public function getAllCitiesByCourierService(CourierService $courierService): array;
    public function courierServiceById(int $id): CourierService;
    public function getAllAddressesByCityAndCourier(City $city, CourierService $courier): array;
    public function addressById(int $id): DeliveryInfo;
}