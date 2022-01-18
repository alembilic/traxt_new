<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxProxies
 *
 * @ORM\Table(name="trx_proxies")
 * @ORM\Entity
 */
class TrxProxies
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
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=191, nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="port", type="string", length=191, nullable=false)
     */
    private $port;

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
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=100, nullable=false)
     */
    private $location;


}
