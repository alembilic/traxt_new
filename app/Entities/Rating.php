<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Ratings
 *
 * @ORM\Table(name="ratings", indexes={@ORM\Index(name="ratings_user_id_foreign", columns={"user_id"}), @ORM\Index(name="ratings_contact_id_foreign", columns={"contact_id"})})
 * @ORM\Entity
 */
class Rating
{
    public const CONTACT = 'contact';
    public const USER = 'user';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer", nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=500, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \Contacts
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="ratings", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $contact;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @param int $value value
     * @param string $comment comment
     * @param User $user user
     * @param Contact $contact contact
     */
    public function __construct(int $value, string $comment, User $user, Contact $contact)
    {
        $this->value = $value;
        $this->comment = $comment;
        $this->user = $user;
        $this->contact = $contact;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }    

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getValueAsPercent(): int
    {
        return $this->value * 100 / 5;
    }    

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }    

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->user->getFirstname() . " " . $this->user->getLastname();
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        $now = new DateTime();
        $days = $this->dateDiffInDays($this->createdAt, $now);
        return $days;
    }

    /**
     * @param int $value
     */
    public function setRatingValue(int $value): void
    {
        $this->value = $value;
    }    

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }       

    // Function to find the difference 
    // between two dates.
    private function dateDiffInDays($date1, $date2) 
    {
        $abs_diff = $date1->diff($date2)->format("%a"); //3

        return $abs_diff;
    }
}
