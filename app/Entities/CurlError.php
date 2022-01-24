<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurlError
 *
 * @ORM\Table(name="curl_error")
 * @ORM\Entity
 */
class CurlError
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
     * @ORM\Column(name="target_url", type="string", length=450, nullable=false)
     */
    private $targetUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="error", type="string", length=450, nullable=false)
     */
    private $error;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tstamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $tstamp = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="erro_no", type="integer", nullable=false)
     */
    private $erroNo;


}
