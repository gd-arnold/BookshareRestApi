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
     * @var bool
     *
     * @ORM\Column(name="isAccepted", type="boolean")
     */
    private $isAccepted = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="isReadByRequester", type="boolean", nullable=true)
     */
    private $isReadByRequester = null;

    /**
     * @var bool
     *
     * @ORM\Column(name="isReadByReceiver", type="boolean")
     */
    private $isReadByReceiver = false;


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
     * Set isReadByRequester.
     *
     * @param bool $isReadByRequester
     *
     * @return BookRequest
     */
    public function setIsReadByRequester($isReadByRequester)
    {
        $this->isReadByRequester = $isReadByRequester;

        return $this;
    }

    /**
     * Get isReadByRequester.
     *
     * @return bool
     */
    public function getIsReadByRequester()
    {
        return $this->isReadByRequester;
    }

    /**
     * Set isReadByReceiver.
     *
     * @param bool $isReadByReceiver
     *
     * @return BookRequest
     */
    public function setIsReadByReceiver($isReadByReceiver)
    {
        $this->isReadByReceiver = $isReadByReceiver;

        return $this;
    }

    /**
     * Get isReadByReceiver.
     *
     * @return bool
     */
    public function getIsReadByReceiver()
    {
        return $this->isReadByReceiver;
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
