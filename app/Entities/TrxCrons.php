<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxCrons
 *
 * @ORM\Table(name="trx_crons")
 * @ORM\Entity
 */
class TrxCrons
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cronJobId", type="string", length=36, nullable=false, options={"fixed"=true})
     */
    private $cronjobid;

    /**
     * @var int
     *
     * @ORM\Column(name="handleId", type="integer", nullable=false)
     */
    private $handleid;

    /**
     * @var int
     *
     * @ORM\Column(name="handleType", type="integer", nullable=false)
     */
    private $handletype;

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


}
