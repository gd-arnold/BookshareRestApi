<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SuggestedBook
 *
 * @ORM\Table(name="suggested_books")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\SuggestedBooksRepository")
 */
class SuggestedBook
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
     * @var string
     *
     * @ORM\Column(name="bookTitle", type="string", length=255)
     */
    private $bookTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="bookAuthor", type="string", length=255)
     */
    private $bookAuthor;


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
     * Set bookTitle.
     *
     * @param string $bookTitle
     *
     * @return SuggestedBook
     */
    public function setBookTitle($bookTitle)
    {
        $this->bookTitle = $bookTitle;

        return $this;
    }

    /**
     * Get bookTitle.
     *
     * @return string
     */
    public function getBookTitle()
    {
        return $this->bookTitle;
    }

    /**
     * Set bookAuthor.
     *
     * @param string $bookAuthor
     *
     * @return SuggestedBook
     */
    public function setBookAuthor($bookAuthor)
    {
        $this->bookAuthor = $bookAuthor;

        return $this;
    }

    /**
     * Get bookAuthor.
     *
     * @return string
     */
    public function getBookAuthor()
    {
        return $this->bookAuthor;
    }
}
