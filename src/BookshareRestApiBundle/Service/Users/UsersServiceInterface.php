<?php


namespace BookshareRestApiBundle\Service\Users;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\DeliveryInfo;
use BookshareRestApiBundle\Entity\User;

interface UsersServiceInterface
{
    public function save(User $user) : bool;
    public function userById(int $id): ?User;
    public function getCurrentUser(): ?User;
    public function update(User $user): bool;
    public function addBook(Book $book): bool;
    public function removeBook(Book $book): bool;
    public function getUserFavouriteSubcategories(): array;
    public function getUsersFavouriteSubcategoriesByBook(Book $book, User $user): array;
    public function addDeliveryInfo(DeliveryInfo $deliveryInfo): bool;
    public function updatePhoneNumber(string $phoneNumber): bool;
}