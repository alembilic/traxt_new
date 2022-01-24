<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifications
 *
 * @ORM\Table(name="notifications", indexes={@ORM\Index(name="user_id_2", columns={"user_id", "id_domain"}), @ORM\Index(name="user_id", columns={"user_id", "id_domain"})})
 * @ORM\Entity
 */
class Notifications
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stamp", type="datetime", nullable=false)
     */
    private $stamp;

    /**
     * @var int
     *
     * @ORM\Column(name="id_domain", type="integer", nullable=false)
     */
    private $idDomain;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default"="1"})
     */
    private $status = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=400, nullable=false)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="mail", type="integer", nullable=false)
     */
    private $mail = '0';


}
