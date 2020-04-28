<?php


namespace BookshareRestApiBundle\Service\Users;


use BookshareRestApiBundle\Entity\Book;
use BookshareRestApiBundle\Entity\BookRequest;
use BookshareRestApiBundle\Entity\DeliveryInfo;
use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Repository\UserRepository;
use BookshareRestApiBundle\Service\Encryption\BCryptService;
use Symfony\Component\Security\Core\Security;

class UserService implements UsersServiceInterface
{

    private $userRepository;
    private $encryptionService;
    private $security;

    public function __construct(UserRepository $userRepository,
                                BCryptService $encryptionService,
                                Security $security)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
        $this->security = $security;
    }

    public function save(User $user): bool
    {
        $passwordHash =
            $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);

        return $this->userRepository->insert($user);
    }

    /**
     * @param int $id
     * @return User|null|object
     */
    public function userById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @return User|null|object
     */
    public function getCurrentUser(): ?User
    {
        return $this->security->getToken()->getUser();
    }

    public function update(User $user): bool
    {
        return $this->userRepository->merge($user);
    }

    public function addBook(Book $book): bool
    {
        $this->getCurrentUser()->getBooks()[] = $book;
        return $this->update($this->getCurrentUser());
    }

    public function removeBook(Book $book): bool
    {
        $this->getCurrentUser()->getBooks()->removeElement($book);
        return $this->update($this->getCurrentUser());
    }

    public function getUserFavouriteSubcategories(): array
    {
        $currentUser = $this->getCurrentUser();
        $subcategories = $this->userRepository->findUserFavouriteSubcategories($currentUser);
        return array_map(function($subcategories) {
            return $subcategories['subcategoryName'];
        }, $subcategories);
    }

    public function getUsersFavouriteSubcategoriesByBook(Book $book, User $user): array
    {
        $potentialUsers = $this->userRepository->findUsersByBook($book, $user);
        $potentialUsersSubcategories = [];
        foreach ($potentialUsers as $potentialUser) {
            /** @var User $potentialUser */
            $potentialUsersSubcategories[$potentialUser->getId()] = $this->userRepository->findUserFavouriteSubcategories($potentialUser);
        }
        return $potentialUsersSubcategories;
    }

    public function addDeliveryInfo(DeliveryInfo $deliveryInfo): bool
    {
        $this->getCurrentUser()->getAddresses()[] = $deliveryInfo;
        return $this->update($this->getCurrentUser());
    }
}