<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * IgnoreLinks
 *
 * @ORM\Table(name="ignore_links", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class IgnoreLinks
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
     * @ORM\Column(name="id_external_links", type="bigint", nullable=false)
     */
    private $idExternalLinks;

    /**
     * @var int
     *
     * @ORM\Column(name="ignore_link", type="integer", nullable=false)
     */
    private $ignoreLink;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="bigint", nullable=false)
     */
    private $userId;


}
