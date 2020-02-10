<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subcategory
 *
 * @ORM\Table(name="subcategories")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\SubcategoryRepository")
 */
class Subcategory
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
     * @ORM\Column(name="subcategoryName", type="string", length=255, unique=true)
     */
    private $subcategoryName;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="BookshareRestApiBundle\Entity\Category", inversedBy="subcategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

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
     * Set subcategoryName.
     *
     * @param string $subcategoryName
     *
     * @return Subcategory
     */
    public function setSubcategoryName($subcategoryName)
    {
        $this->subcategoryName = $subcategoryName;

        return $this;
    }

    /**
     * Get subcategoryName.
     *
     * @return string
     */
    public function getSubcategoryName()
    {
        return $this->subcategoryName;
    }

    /**
     * @param Category $category
     *
     * @return Subcategory
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
}
