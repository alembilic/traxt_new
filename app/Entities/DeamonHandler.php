<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeamonHandler
 *
 * @ORM\Table(name="deamon_handler")
 * @ORM\Entity
 */
class DeamonHandler
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
     * @ORM\Column(name="unik_id", type="string", length=200, nullable=false)
     */
    private $unikId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $timestamp = 'CURRENT_TIMESTAMP';


}
