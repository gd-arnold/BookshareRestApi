<?php

namespace BookshareBundle\Service\Users;


use BookshareRestApiBundle\Entity\User;
use BookshareRestApiBundle\Repository\UserRepository;
use BookshareRestApiBundle\Service\Encryption\BCryptService;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;

class UserService implements UsersServiceInterface
{

    private $userRepository;
    private $encryptionService;

    public function __construct(UserRepository $userRepository,
                                BCryptService $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    public function save(User $user): bool
    {
        $passwordHash =
            $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);

        return $this->userRepository->insert($user);
    }
}