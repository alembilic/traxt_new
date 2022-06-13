<?php

namespace App\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contacts
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 */
class Contact implements \JsonSerializable
{
    public const EMAIL = 'email';
    public const DOMAINS = 'domains';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="domains", type="text", length=0, nullable=false)
     */
    private $domains;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="contact", cascade={"persist", "remove"})
     **/
    private $ratings;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    public static function createFromPayload(string $fistName, string $lastName, string $email, string $domains ): Contact
    {
        $createdContact = new self();
        $createdContact -> firstName = $fistName;
        $createdContact -> lastName = $lastName;
        $createdContact -> email = $email;
        $createdContact -> domains = $domains;
        return $createdContact;
    }

    public function jsonSerialize(): array
    {
        return array(
            'firstName' => $this -> firstName,
            'lastName' => $this -> lastName,
            'email' => $this -> email,
            'domain' => $this -> domains
        );
    }

    public function __construct() {
        $this->ratings = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        if (!count($this->ratings)) {
            return 0;
        }

        $total = 0;
        foreach ($this->ratings as $rating) {
            $total += $rating->getValue();
        }

        return round(($total / count($this->ratings)) * 2) / 2;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getDomains(): string
    {
        return $this->domains ? explode(',', $this->domains) : [];
    }

}
