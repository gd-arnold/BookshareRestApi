<?php


namespace BookshareRestApiBundle\Service\Books;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\Category;
use BookshareRestApiBundle\Entity\Subcategory;
use BookshareRestApiBundle\Entity\SuggestedBook;

interface BookServiceInterface
{
    public function bookById(int $id): ?Book;
    public function update(Book $book): bool;
    public function getBooksBySearch(string $search): array ;
    public function sortBooksBySearch(Book $firstBook, Book $secondBook, string $search): bool;
    public function getAllBooks(): array;
    public function getBooksByCurrentUser(): array;
    public function getMostExchangedBooks(): array;
    public function getNewestBooks(): array;
    public function getSuggestedBooksForUser(): array;
    public function save(Book $book): bool;
    public function getAllCategories(): array;
    public function categoryById(string $id): Category;
    public function getAllSubcategoriesByCategory(Category $category): array;
    public function subcategoryById(string $id): Subcategory;
    public function bookSuggestionById(string $id): SuggestedBook;
    public function deleteBookSuggestion(SuggestedBook $suggestion): bool;
}