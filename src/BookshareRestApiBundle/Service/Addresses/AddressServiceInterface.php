<?php


namespace BookshareRestApiBundle\Service\Addresses;


interface AddressServiceInterface
{
    public function getAllCourierServices(): array;
}