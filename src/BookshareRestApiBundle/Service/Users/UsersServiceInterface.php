<?php


namespace BookshareRestApiBundle\Service\Users;


use BookshareRestApiBundle\Entity\User;

interface UsersServiceInterface
{
    public function save(User $user) : bool;
}