<?php

namespace BookshareRestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\AttributeOverride;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\Column;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="BookshareRestApiBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @AttributeOverrides({
 *      @AttributeOverride(name="username",
 *          column=@Column(
 *              name     = "username",
 *              nullable = false,
 *              unique   = true,
 *              length   = 255
 *          )
 *      ),
 *      @AttributeOverride(name="email",
 *          column=@Column(
 *              name     = "email",
 *              nullable = false,
 *              unique   = true,
 *              length   = 255
 *          )
 *      ),
 *      @AttributeOverride(name="password",
 *          column=@Column(
 *              name     = "password",
 *              nullable = false,
 *              unique   = false,
 *              length   = 255
 *          )
 *      )
 * })
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255, nullable=true)
     */
    protected $phoneNumber = null;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    protected $address;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="BookshareRestApiBundle\Entity\Book", inversedBy="users")
     * @ORM\JoinTable(name="users_books",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="book_id",referencedColumnName="id")}
     *     )
     */
    private $books;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="BookshareRestApiBundle\Entity\DeliveryInfo", inversedBy="users")
     * @ORM\JoinTable(name="users_addresses",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="address_id",referencedColumnName="id")}
     *     )
     */
    private $addresses;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\BookRequest", mappedBy="requester")
     */
    private $requests;

    /**
    * @var ArrayCollection
    *
    * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\BookRequest", mappedBy="receiver")
    */
    private $receipts;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\SuggestedBook", mappedBy="proposer")
     */
    private $suggestions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BookshareRestApiBundle\Entity\Message", mappedBy="sender")
     */
    private $messages;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param ArrayCollection $books
     */
    public function setBooks(ArrayCollection $books): void
    {
        $this->books = $books;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param ArrayCollection $addresses
     */
    public function setAddresses(ArrayCollection $addresses): void
    {
        $this->addresses = $addresses;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * @param ArrayCollection $requests
     * @return User
     */
    public function setRequests(ArrayCollection $requests): User
    {
        $this->requests = $requests;

        return $this;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getReceipts()
    {
        return $this->receipts;
    }

    /**
     * @param ArrayCollection $receipts
     * @return User
     */
    public function setReceipts(ArrayCollection $receipts): User
    {
        $this->receipts = $receipts;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function enableUser(){
        $this->setEnabled(true);
    }

    /**
     * @return ArrayCollection
     */
    public function getSuggestions(): ArrayCollection
    {
        return $this->suggestions;
    }

    /**
     * @param ArrayCollection $suggestions
     *
     * @return User
     */
    public function setSuggestions(ArrayCollection $suggestions)
    {
        $this->suggestions = $suggestions;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMessages(): ArrayCollection
    {
        return $this->messages;
    }

    /**
     * @param ArrayCollection $messages
     *
     * @return User
     */
    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}

