<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bugs
 *
 * @ORM\Table(name="bugs")
 * @ORM\Entity
 */
class Bugs
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
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="imported_url_id", type="integer", nullable=false)
     */
    private $importedUrlId;

    /**
     * @var string
     *
     * @ORM\Column(name="report", type="text", length=65535, nullable=false)
     */
    private $report;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $added = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=false)
     */
    private $state = '0';


}
