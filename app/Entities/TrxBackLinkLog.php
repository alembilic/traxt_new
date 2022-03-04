<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * TrxBackLinkLog
 *
 * @ORM\Table(name="trx_backlinks_logs")
 *
 * @ORM\Entity
 */
class TrxBackLinkLog
{
    use Timestamps;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Domain of this link.
     *
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain")
     *
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     */
    private $domain;

    /**
     * Backlink.
     *
     * @var TrxBackLink
     *
     * @ORM\ManyToOne(targetEntity="TrxBackLink")
     *
     * @ORM\JoinColumn(name="backlink_id", referencedColumnName="id")
     */
    private $backLink;

    /**
     * @var string|null
     *
     * @ORM\Column(name="data", type="string", length=100, nullable=true)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private string $status = 'ok';

    /**
     * @param Domain $domain related Domain
     * @param string $data payload
     * @param string $status status
     */
    public function __construct(Domain $domain, TrxBackLink $backLink, string $data, string $status = 'ok')
    {
        $this->data = $data;
        $this->domain = $domain;
        $this->backLink = $backLink;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return $this->domain;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
