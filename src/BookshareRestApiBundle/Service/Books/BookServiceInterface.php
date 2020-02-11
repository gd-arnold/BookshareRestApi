<?php


namespace BookshareRestApiBundle\Service\Books;


use BookshareRestApiBundle\Entity\Book;

interface BookServiceInterface
{
    public function bookById(int $id): ?Book;
    public function update(Book $book): bool;
    public function getBooksBySearch(string $search): array ;
    public function sortBooksBySearch(Book $firstBook, Book $secondBook, string $search): bool;
    public function getAllBooks(): array;
}