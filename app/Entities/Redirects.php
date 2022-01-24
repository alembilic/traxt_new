<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Redirects
 *
 * @ORM\Table(name="redirects")
 * @ORM\Entity
 */
class Redirects
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
     * @ORM\Column(name="id_external_links", type="integer", nullable=false)
     */
    private $idExternalLinks;

    /**
     * @var string
     *
     * @ORM\Column(name="dest_url", type="string", length=400, nullable=false)
     */
    private $destUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="redirects", type="integer", nullable=false)
     */
    private $redirects;


}
