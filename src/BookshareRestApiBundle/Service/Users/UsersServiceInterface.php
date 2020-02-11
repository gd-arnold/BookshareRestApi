<?php


namespace BookshareRestApiBundle\Service\Users;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\User;

interface UsersServiceInterface
{
    public function save(User $user) : bool;
    public function getCurrentUser(): ?User;
    public function update(User $user): bool;
    public function addBook(Book $book): bool;
}