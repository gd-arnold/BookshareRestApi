<?php


namespace BookshareRestApiBundle\Service\Cities;


use BookshareRestApiBundle\Entity\City;
use BookshareRestApiBundle\Repository\CityRepository;

class CityService implements CityServiceInterface
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param int $id
     * @return City|object
     */
    public function cityById(int $id): City
    {
        return $this->cityRepository->find($id);
    }

    /**
     * @param string $name
     * @return City
     */
    public function cityByName(string $name): City
    {
        return $this->cityRepository->findBy([
            'cityName' => $name
        ])[0];
    }
}