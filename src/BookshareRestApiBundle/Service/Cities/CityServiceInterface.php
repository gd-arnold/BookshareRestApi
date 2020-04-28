<?php


namespace BookshareRestApiBundle\Service\Cities;


use BookshareRestApiBundle\Entity\City;

interface CityServiceInterface
{
    public function cityById(int $id): City;
    public function cityByName(string $name): City;
}