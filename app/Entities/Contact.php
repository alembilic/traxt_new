<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contacts
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 */
class Contact
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

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

    public function __construct() {
        $this->ratings = new ArrayCollection();
    }

    /**
    * @return string
    */
    public function getFirstname(): string
    {
        return $this->firstname;
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
    public function getLastname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return $this->firstname . " " . $this->lastname;
    }    

     /**
     * @return float
     */
    public function getRating(): float
    {
        if(count($this->ratings)==0){
            return 0;
        }

        $total = 0;
        foreach ($this->ratings as $rating) {
            $total += $rating->getValue();
        }

        return round(($total/count($this->ratings))*2)/2;
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
        $array = $this->domains ? explode(',', $this->domains) : []; 

        return $array;
    }    

}
