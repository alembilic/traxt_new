<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Links
 *
 * @ORM\Table(name="links", indexes={@ORM\Index(name="id_imported_urls", columns={"id_imported_urls"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Links
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;


}
