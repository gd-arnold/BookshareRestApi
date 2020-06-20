<?php


namespace BookshareRestApiBundle\Service\Suggestions;


use BookshareRestApiBundle\Entity\SuggestedBook;

interface SuggestionServiceInterface
{
    public function createSuggestion(string $bookTitle, string $bookAuthor): bool;
    public function getAllBookSuggestions(): array;
    public function deleteBookSuggestion(SuggestedBook $suggestion): bool;
    public function bookSuggestionById(string $id): SuggestedBook;
}