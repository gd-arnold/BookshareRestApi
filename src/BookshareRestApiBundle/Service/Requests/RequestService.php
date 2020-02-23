<?php


namespace BookshareRestApiBundle\Service\Requests;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\BookRequest;
use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Repository\BookRequestsRepository;
use BookshareRestApiBundle\Service\Books\BookServiceInterface;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestService implements RequestServiceInterface
{
    private $userService;
    private $bookRequestRepository;
    private $bookService;

    public function __construct(UsersServiceInterface $userService,
                                BookRequestsRepository $bookRequestRepository,
                                BookServiceInterface $bookService)
    {
        $this->userService = $userService;
        $this->bookRequestRepository = $bookRequestRepository;
        $this->bookService = $bookService;
    }

    /**
     * @param Book $book
     * @return User|null|object
     */
    public function getPotentialUser(Book $book): ?User
    {
        $currUser = $this->userService->getCurrentUser();
        $currUserSubcategories = $this->userService->getUserFavouriteSubcategories();
        $potentialUsersSubcategories = $this->userService->getUsersFavouriteSubcategoriesByBook($book, $currUser);
        $maxPoints = -5;
        $perfectUserId = null;
        foreach ($potentialUsersSubcategories as $userId => $subcategories) {
            $points = 0;
            if (count($subcategories) > count($currUserSubcategories)) {
                for ($i = count($currUserSubcategories); $i <= count($subcategories); $i++) {
                    array_push($currUserSubcategories, "null");
                }
            }
            for ($i = count($subcategories) - 1; $i >= 0; $i--) {
                $currUserSubcategory = $currUserSubcategories[$i];
                $currSubcategory = $subcategories[$i]['subcategoryName'];
                if ($currUserSubcategory == $currSubcategory) {
                    $points += ($i + 1) * 5;
                } else if (in_array($currSubcategory, $currUserSubcategories)) {
                    $points += 2;
                }

            }
            if ($points > $maxPoints) {
                $maxPoints = $points;
                $perfectUserId = $userId;
            }
        }
        return $this->userService->userById($perfectUserId);
    }

    public function createRequest(Book $book): bool {

        $request = new BookRequest();
        $potentialUser = $this->getPotentialUser($book);
        $request->setRequester($this->userService->getCurrentUser());
        $request->setReceiver($potentialUser);
        $request->setRequestedBook($book);

        return $this->bookRequestRepository->save($request);
    }

    /**
     * @param int $id
     * @return BookRequest|null|object
     */
    public function requestById(int $id): ?BookRequest
    {
        return $this->bookRequestRepository->find($id);
    }

    public function acceptRequest(int $requestId, int $bookId): bool
    {
        $request = $this->requestById($requestId);

        $request->setChosenBook($this->bookService->bookById($bookId));
        $request->setIsAccepted(true);
        $request->setIsReadByRequester(false);

        return $this->bookRequestRepository->merge($request);
    }

    public function isCurrentUserReceiver(int $id): bool
    {
        $request = $this->requestById($id);
        
        if ($request->getReceiver() === $this->userService->getCurrentUser()) {
            return true;
        }
        return false;
    }

    public function getAllUnreadRequestsForCurrentUserCount(): string
    {
        return $this->bookRequestRepository
            ->findAllUnreadRequestsForCurrentUserCount($this->userService->getCurrentUser());
    }

    public function getAllRequestsForCurrentUser(): array
    {
        return $this->bookRequestRepository
            ->findAllRequestsForCurrentUser($this->userService->getCurrentUser());
    }
}