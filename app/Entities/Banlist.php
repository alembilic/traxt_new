<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banlist
 *
 * @ORM\Table(name="banlist")
 * @ORM\Entity
 */
class Banlist
{
    /**
     * @var int
     *
     * @ORM\Column(name="ban_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $banId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ban_username", type="string", length=255, nullable=true)
     */
    private $banUsername = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="ban_userid", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $banUserid = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ban_ip", type="string", length=40, nullable=true)
     */
    private $banIp = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="timestamp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $timestamp;


}
