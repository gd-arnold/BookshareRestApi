<?php


namespace BookshareRestApiBundle\Service\Requests;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\BookRequest;
use BookshareRestApiBundle\Entity\User;

interface RequestServiceInterface
{
    public function getPotentialUser(Book $book): ?User;
    public function createRequest(Book $book): bool;
    public function requestById(int $id): ?BookRequest;
    public function acceptRequest(int $requestId, int $bookId): bool;
}