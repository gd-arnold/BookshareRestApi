<?php


namespace BookshareRestApiBundle\Service\Messages;


use BookshareRestApiBundle\Entity\Message;

interface MessageServiceInterface
{
    public function createMessage(string $description): bool;
    public function getAllMessages(): array;
    public function messageById(int $messageId): Message;
    public function deleteMessage(Message $message): bool;
}