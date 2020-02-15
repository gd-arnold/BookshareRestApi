<?php


namespace BookshareRestApiBundle\Service\Requests;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\BookRequest;
use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Repository\BookRequestsRepository;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestService implements RequestServiceInterface
{
    private $userService;
    private $bookRequestRepository;

    public function __construct(UsersServiceInterface $userService,
                                BookRequestsRepository $bookRequestRepository)
    {
        $this->userService = $userService;
        $this->bookRequestRepository = $bookRequestRepository;
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
        $maxPoints = 0;
        $perfectUserId = null;

        foreach ($potentialUsersSubcategories as $userId => $subcategories) {
            $points = 0;
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

        $request->setRequester($this->userService->getCurrentUser());
        $request->setReceiver($this->getPotentialUser($book));
        $request->setRequestedBook($book);

        return $this->bookRequestRepository->save($request);
    }

}