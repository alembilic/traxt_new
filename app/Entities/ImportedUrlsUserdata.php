<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportedUrlsUserdata
 *
 * @ORM\Table(name="imported_urls_userdata", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class ImportedUrlsUserdata
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
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=1000, nullable=false)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=17, nullable=false)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="id_valuta", type="integer", nullable=false)
     */
    private $idValuta;


}
