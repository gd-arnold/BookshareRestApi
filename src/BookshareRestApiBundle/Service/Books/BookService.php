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

    public function getBooksBySearch(string $search): array
    {
        $books = $this->getAllBooks();
        $books = array_filter($books, function ($book) use ($search) {
            /** @var Book $book */
            if (mb_stripos($book->getTitle(), $search) !== false) {
                return true;
            } return false;
        });
        usort($books, function ($a, $b) use ($search) {
            $this->sortBooksBySearch($a, $b, $search);
        });
        return $books;
    }

    public function sortBooksBySearch(Book $firstBook, Book $secondBook, string $search): bool
    {
        $firstBookPosition = mb_stripos($firstBook->getTitle(), $search);
        $secondBookPosition = mb_stripos($secondBook->getTitle(), $search);

        if ( $firstBookPosition === $secondBookPosition ) {
            if ( $firstBook->getRating() === $secondBook->getRating()) {
                if ( $firstBook->getDatePublished() === $secondBook->getDatePublished()) {
                    return 0;
                }
                return (strtotime($firstBook->getDatePublished()) > strtotime($secondBook->getDatePublished())) ? +1 : -1;
            }
            return ($firstBook->getRating() > $secondBook->getRating()) ? -1 : +1;
        }

        return ($firstBookPosition > $secondBookPosition) ? +1 : -1;
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }
}