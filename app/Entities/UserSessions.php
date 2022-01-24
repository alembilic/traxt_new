<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSessions
 *
 * @ORM\Table(name="user_sessions")
 * @ORM\Entity
 */
class UserSessions
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
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $sessionId;

    /**
     * @var string
     *
     * @ORM\Column(name="hashedValidator", type="string", length=64, nullable=false, options={"fixed"=true})
     */
    private $hashedvalidator;

    /**
     * @var bool
     *
     * @ORM\Column(name="persistent", type="boolean", nullable=false)
     */
    private $persistent = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="ipaddress", type="string", length=15, nullable=false)
     */
    private $ipaddress = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="timestamp", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $timestamp = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="expires", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $expires;


}
