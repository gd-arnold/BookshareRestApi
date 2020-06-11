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

    public function updatePhoneNumber(string $phoneNumber): bool
    {
        $currUser = $this->getCurrentUser();
        $currUser->setPhoneNumber($phoneNumber);
        return $this->update($currUser);
    }

    public function updateUserBasicData(array $data, int $userId): bool
    {
        $user = $this->userById($userId);
        $currUser = $this->getCurrentUser();

        if ($currUser->getId() !== $user->getId() && !$currUser->hasRole('ADMIN')) {
            throw new \Exception("Invalid User!");
        }

        $data["email"] !== null ? $user->setEmail($data["email"]) : false;
        $data["firstName"] !== null ? $user->setFirstName($data["firstName"]) : false;
        $data["lastName"] !== null ? $user->setLastName($data["lastName"]) : false;

        return $this->update($user);
    }

    public function updatePassword(string $currPassword, string $newPassword)
    {
        if (!$this->encryptionService->verify($currPassword, $this->getCurrentUser()->getPassword())) {
            throw new \Exception("Invalid password");
        }

        $currUser = $this->getCurrentUser();
        $currUser->setPassword($this->encryptionService->hash($newPassword));

        return $this->update($currUser);
    }

    public function getAllUsersBasicData(): array
    {
        $currUser = $this->getCurrentUser();

        if (!$currUser->hasRole("ADMIN")) {
            throw new \Exception("Invalid User!");
        }

        return $this->userRepository->findAll();
    }

    public function getUserBasicDataById(string $id): ?User
    {
        $user = $this->userById($id);
        $currUser = $this->getCurrentUser();

        if ($user->getId() !== $currUser->getId() && !$currUser->hasRole("ADMIN")) {
            throw new \Exception("Invalid User!");
        }

        return $user;
    }
}