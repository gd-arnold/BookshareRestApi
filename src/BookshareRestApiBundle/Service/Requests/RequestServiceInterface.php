<?php


namespace BookshareRestApiBundle\Service\Requests;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\User;

interface RequestServiceInterface
{
    public function getPotentialUser(Book $book): ?User;
    public function createRequest(Book $book): bool;
}