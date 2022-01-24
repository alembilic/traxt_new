<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * DelayLog
 *
 * @ORM\Table(name="delay_log", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="id_imported_urls", columns={"id_imported_urls"})})
 * @ORM\Entity
 */
class DelayLog
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
     * @ORM\Column(name="id_imported_urls", type="integer", nullable=false)
     */
    private $idImportedUrls;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $stamp = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="respons", type="integer", nullable=false)
     */
    private $respons;

    /**
     * @var int
     *
     * @ORM\Column(name="known_link_count", type="integer", nullable=false)
     */
    private $knownLinkCount;


}
