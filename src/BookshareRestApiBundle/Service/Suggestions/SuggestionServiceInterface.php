<?php


namespace BookshareRestApiBundle\Service\Suggestions;


interface SuggestionServiceInterface
{
    public function createSuggestion(string $bookTitle, string $bookAuthor): bool;
}