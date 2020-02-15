<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookRequest
 *
 * @ORM\Table(name="book_requests")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\BookRequestsRepository")
 */
class BookRequest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\User", inversedBy="requests")
     * @ORM\JoinColumn(name="requester_id", referencedColumnName="id")
     */
    private $requester;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\User", inversedBy="receipts")
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     */
    private $receiver;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\Book", inversedBy="requests")
     * @ORM\JoinColumn(name="requested_book_id", referencedColumnName="id")
     */
    private $requestedBook;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\Book", inversedBy="chooses")
     * @ORM\JoinColumn(name="chosen_book_id", referencedColumnName="id", nullable=true)
     */
    private $chosenBook = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRequested", type="datetime")
     */
    private $dateRequested;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateAccepted", type="datetime", nullable=true)
     */
    private $dateAccepted = null;

    /**
     * @var bool
     *
     * @ORM\Column(name="isAccepted", type="boolean")
     */
    private $isAccepted = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="isRead", type="boolean")
     */
    private $isRead = false;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateRequested.
     *
     * @param \DateTime $dateRequested
     *
     * @return BookRequest
     */
    public function setDateRequested($dateRequested)
    {
        $this->dateRequested = $dateRequested;

        return $this;
    }

    /**
     * Get dateRequested.
     *
     * @return \DateTime
     */
    public function getDateRequested()
    {
        return $this->dateRequested;
    }

    /**
     * Set dateAccepted.
     *
     * @param \DateTime|null $dateAccepted
     *
     * @return BookRequest
     */
    public function setDateAccepted($dateAccepted = null)
    {
        $this->dateAccepted = $dateAccepted;

        return $this;
    }

    /**
     * Get dateAccepted.
     *
     * @return \DateTime|null
     */
    public function getDateAccepted()
    {
        return $this->dateAccepted;
    }

    /**
     * Set isAccepted.
     *
     * @param bool $isAccepted
     *
     * @return BookRequest
     */
    public function setIsAccepted($isAccepted)
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    /**
     * Get isAccepted.
     *
     * @return bool
     */
    public function getIsAccepted()
    {
        return $this->isAccepted;
    }

    /**
     * Set isRead.
     *
     * @param bool $isRead
     *
     * @return BookRequest
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead.
     *
     * @return bool
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * @return User
     */
    public function getRequester(): User
    {
        return $this->requester;
    }

    /**
     * @param User $requester
     * @return BookRequest
     */
    public function setRequester(User $requester): BookRequest
    {
        $this->requester = $requester;

        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver(): User
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     * @return BookRequest
     */
    public function setReceiver(User $receiver): BookRequest
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return Book
     */
    public function getRequestedBook(): Book
    {
        return $this->requestedBook;
    }

    /**
     * @param Book $requestedBook
     * @return BookRequest
     */
    public function setRequestedBook(Book $requestedBook): BookRequest
    {
        $this->requestedBook = $requestedBook;

        return $this;
    }

    /**
     * @return Book
     */
    public function getChosenBook(): Book
    {
        return $this->chosenBook;
    }

    /**
     * @param Book $chosenBook
     * @return BookRequest
     */
    public function setChosenBook(Book $chosenBook): BookRequest
    {
        $this->chosenBook = $chosenBook;

        return $this;
    }
}
