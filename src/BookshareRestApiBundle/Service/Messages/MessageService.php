<?php


namespace BookshareRestApiBundle\Service\Messages;


use BookshareRestApiBundle\Entity\Message;
use BookshareRestApiBundle\Repository\MessageRepository;
use BookshareRestApiBundle\Service\Users\UsersServiceInterface;

class MessageService implements MessageServiceInterface
{
    private $messageRepository;
    private $userService;

    public function __construct(MessageRepository $messageRepository,
                                UsersServiceInterface $userService)
    {
        $this->messageRepository = $messageRepository;
        $this->userService = $userService;
    }

    public function createMessage(string $description): bool
    {
        $msg = new Message();
        $msg->setDescription($description);
        $msg->setSender($this->userService->getCurrentUser());

        return $this->messageRepository->insert($msg);
    }
}