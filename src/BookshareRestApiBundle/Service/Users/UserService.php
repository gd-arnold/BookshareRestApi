<?php


namespace BookshareRestApiBundle\Service\Users;


use BookshareRestApiBundle\Entity\Book;
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
}