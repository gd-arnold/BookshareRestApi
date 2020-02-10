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
}
