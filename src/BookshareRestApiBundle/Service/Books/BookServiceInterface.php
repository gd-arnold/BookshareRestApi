<?php


namespace BookshareRestApiBundle\Service\Books;


use BookshareRestApiBundle\Entity\Book;

interface BookServiceInterface
{
    public function bookById(int $id): ?Book;
    public function update(Book $book): bool;
}