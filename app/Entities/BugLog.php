<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * BugLog
 *
 * @ORM\Table(name="bug_log")
 * @ORM\Entity
 */
class BugLog
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
     * @ORM\Column(name="respons_code", type="string", length=11, nullable=false)
     */
    private $responsCode;

    /**
     * @var string
     *
     * @ORM\Column(name="json_encoded_respons", type="text", length=65535, nullable=false)
     */
    private $jsonEncodedRespons;

    /**
     * @var int
     *
     * @ORM\Column(name="id_imported_url", type="integer", nullable=false)
     */
    private $idImportedUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=1000, nullable=false)
     */
    private $url;


}
