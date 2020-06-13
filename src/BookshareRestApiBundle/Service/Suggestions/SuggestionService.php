<?php


namespace BookshareRestApiBundle\Service\Suggestions;


use BookshareRestApiBundle\Entity\SuggestedBook;
use BookshareRestApiBundle\Repository\SuggestedBooksRepository;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;

class SuggestionService implements SuggestionServiceInterface
{
    private $suggestionRepository;
    private $userService;

    public function __construct(SuggestedBooksRepository $suggestionRepository,
                                UsersServiceInterface $userService)
    {
        $this->suggestionRepository = $suggestionRepository;
        $this->userService = $userService;
    }

    public function createSuggestion(string $bookTitle, string $bookAuthor): bool
    {
        $suggestedBook = new SuggestedBook();
        $suggestedBook->setBookTitle($bookTitle);
        $suggestedBook->setBookAuthor($bookAuthor);
        $suggestedBook->setProposer($this->userService->getCurrentUser());

        return $this->suggestionRepository->insert($suggestedBook);
    }

    public function getAllBookSuggestions(): array
    {
        if (!$this->userService->getCurrentUser()->hasRole('ADMIN')) {
            throw new \Exception("Invalid User!");
        }

        return $this->suggestionRepository->findAll();
    }
}