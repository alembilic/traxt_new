<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTemp
 *
 * @ORM\Table(name="user_temp")
 * @ORM\Entity
 */
class UserTemp
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="timestamp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=255, nullable=false)
     */
    private $detail;


}
