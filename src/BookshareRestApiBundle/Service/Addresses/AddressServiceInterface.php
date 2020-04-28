<?php


namespace BookshareRestApiBundle\Service\Addresses;


use BookshareRestApiBundle\Entity\CourierService;

interface AddressServiceInterface
{
    public function getAllCourierServices(): array;
    public function getAllCitiesByCourierService(CourierService $courierService): array;
    public function courierServiceById(int $id): CourierService;
}