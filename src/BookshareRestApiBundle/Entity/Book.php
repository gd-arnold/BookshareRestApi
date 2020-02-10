<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\BookRepository")
 */
class Book
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="publisher", type="string", length=255)
     */
    private $publisher;

    /**
     * @var string
     *
     * @ORM\Column(name="datePublished", type="string", length=255)
     */
    private $datePublished;

    /**
     * @var string
     *
     * @ORM\Column(name="pages", type="string", length=255)
     */
    private $pages;

    /**
     * @var string
     *
     * @ORM\Column(name="imageURL", type="text")
     */
    private $imageURL;

    /**
     * @var Subcategory
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\Subcategory", inversedBy="books")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $subcategory;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;


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
     * Set title.
     *
     * @param string $title
     *
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author.
     *
     * @param string $author
     *
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set publisher.
     *
     * @param string $publisher
     *
     * @return Book
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher.
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set datePublished.
     *
     * @param string $datePublished
     *
     * @return Book
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * Get datePublished.
     *
     * @return string
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * Set pages.
     *
     * @param string $pages
     *
     * @return Book
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages.
     *
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set imageURL.
     *
     * @param string $imageURL
     *
     * @return Book
     */
    public function setImageURL($imageURL)
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    /**
     * Get imageURL.
     *
     * @return string
     */
    public function getImageURL()
    {
        return $this->imageURL;
    }

    /**
     * @param Subcategory $subcategory
     *
     * @return Book
     */
    public function setSubcategory(Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * @return Subcategory
     */
    public function getSubcategory(): Subcategory
    {
        return $this->subcategory;
    }

    /**
     * Set rating.
     *
     * @param int $rating
     *
     * @return Book
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating.
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
}
