<?php


namespace BookshareRestApiBundle\Service\Requests;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\BookRequest;
use BookshareRestApiBundle\Entity\DeliveryInfo;
use BookshareRestApiBundle\Entity\User;

interface RequestServiceInterface
{
    public function getPotentialUser(Book $book): ?User;
    public function createRequest(Book $book, DeliveryInfo $address): bool;
    public function requestById(int $id): ?BookRequest;
    public function acceptRequest(int $requestId, int $bookId, int $addressId): bool;
    public function isCurrentUserReceiver(int $id) :bool;
    public function getAllUnreadRequestsForCurrentUserCount(): string;
    public function getAllRequestsForCurrentUser(): array;
    public function readAllUnreadRequests(): bool;
    public function cancelRequest(BookRequest $request): bool;
}