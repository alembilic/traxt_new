<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * ActiveGuests
 *
 * @ORM\Table(name="active_guests")
 * @ORM\Entity
 */
class ActiveGuests
{
    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ip;

    /**
     * @var int
     *
     * @ORM\Column(name="timestamp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $timestamp;


}
