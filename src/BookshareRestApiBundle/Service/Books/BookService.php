<?php


namespace BookshareRestApiBundle\Service\Books;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Repository\BookRepository;

class BookService implements BookServiceInterface
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param int $id
     * @return Book|null|object
     */
    public function bookById(int $id): ?Book
    {
        return $this->bookRepository->find($id);
    }

    public function update(Book $book): bool
    {
        return $this->bookRepository->merge($book);
    }
}