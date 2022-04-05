<?php

namespace App\Entities;

use App\Contracts\IHasUser;
use App\Dto\BackLinksRawData;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * BackLink
 *
 * @ORM\Table(name="backlinks")
 *
 * @ORM\Entity
 */
class BackLink implements IHasUser
{
    use Timestamps;

    public const ID = 'id';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const SOURCE_URL = 'sourceUrl';
    public const DEST_URL = 'destUrl';
    public const DOMAIN = 'domain';
    public const CREATED_BY = 'createdBy';
    public const LOST = 'lost';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * Domain of this link.
     *
     * @var Domain
     *
     * @ORM\ManyToOne(targetEntity="Domain", inversedBy="backLinks")
     *
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     */
    private Domain $domain;

    /**
     * User whose created this link.
     *
     * @var User
     *
     * @Gedmo\Blameable(on="create")
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private User $createdBy;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", nullable=false)
     */
    private string $sourceUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="dest", type="string", nullable=false)
     */
    private string $destUrl;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nofollow", type="bool", nullable=false)
     */
    private bool $nofollow = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="alt", type="bool", nullable=false)
     */
    private bool $alt = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="anchor", type="bool", nullable=false)
     */
    private bool $anchor = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="noindex", type="boolean", nullable=false)
     */
    private bool $noindex = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="sponsored", type="boolean", nullable=false)
     */
    private bool $sponsored = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="ugc", type="boolean", nullable=false)
     */
    private bool $ugc = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_lost", type="boolean", nullable=false)
     */
    private bool $lost = false;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer", length=3, nullable=false)
     */
    private int $rank = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="status_code", type="integer", length=3, nullable=false)
     */
    private int $statusCode = 200;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="first_seen", type="datetime", nullable=false)
     */
    private DateTime $firstSeen;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_seen", type="datetime", nullable=false)
     */
    private DateTime $lastSeen;

    /**
     * @param string $sourceUrl source
     * @param string $destUrl dest
     * @param Domain $domain related Domain
     * @param ?User $user related User
     */
    public function __construct(string $sourceUrl, string $destUrl, Domain $domain, ?User $user = null)
    {
        $this->sourceUrl = $sourceUrl;
        $this->destUrl = $destUrl;
        $this->domain = $domain;
        $this->createdBy = $user ?? $domain->getCreatedBy();
        $this->firstSeen = new DateTime();
        $this->lastSeen = new DateTime();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function fill(BackLinksRawData $data): void
    {
        $fields = $data->getInitializedFields();
        if (in_array(BackLinksRawData::REL_SPONSORED, $fields)) {
            $this->sponsored = (bool)$data->relSponsored;
        }
        if (in_array(BackLinksRawData::REL_NOINDEX, $fields)) {
            $this->noindex = (bool)$data->relNoindex;
        }
        if (in_array(BackLinksRawData::REL_NOFOLLOW, $fields)) {
            $this->nofollow = (bool)$data->relNofollow;
        }
        if (in_array(BackLinksRawData::REL_UGC, $fields)) {
            $this->ugc = (bool)$data->relUgc;
        }
        if (in_array(BackLinksRawData::ANCHOR_TEXT, $fields)) {
            $this->anchor = (bool)$data->anchorText;
        }
        if (in_array(BackLinksRawData::ALT, $fields)) {
            $this->alt = (bool)$data->alt;
        }
        if (in_array(BackLinksRawData::IS_LOST, $fields)) {
            $this->lost = (bool)$data->isLost;
        }
        if (in_array(BackLinksRawData::RANK, $fields)) {
            $this->rank = (int)$data->rank;
        }
        if (in_array(BackLinksRawData::RESPONSE, $fields)) {
            $this->statusCode = (int)$data->response;
        }
        if (in_array(BackLinksRawData::FIRST_FOUND, $fields)) {
            $this->firstSeen = $data->firstFound;
        }
        if (in_array(BackLinksRawData::LAST_FOUND, $fields)) {
            $this->lastSeen = $data->lastFound;
        }
        $this->updatedAt = new DateTime();
    }

    /**
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return $this->domain;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }

    /**
     * @return string
     */
    public function getDestUrl(): string
    {
        return $this->destUrl;
    }

    /**
     * @return bool
     */
    public function isNofollow(): bool
    {
        return $this->nofollow;
    }

    /**
     * @return bool
     */
    public function isAlt(): bool
    {
        return $this->alt;
    }

    /**
     * @return bool
     */
    public function isAnchor(): bool
    {
        return $this->anchor;
    }

    /**
     * @return bool
     */
    public function isNoindex(): bool
    {
        return $this->noindex;
    }

    /**
     * @return bool
     */
    public function isSponsored(): bool
    {
        return $this->sponsored;
    }

    /**
     * @return bool
     */
    public function isUgc(): bool
    {
        return $this->ugc;
    }

    /**
     * @return bool
     */
    public function isLost(): bool
    {
        return $this->lost;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return DateTime
     */
    public function getFirstSeen(): DateTime
    {
        return $this->firstSeen;
    }

    /**
     * @return DateTime
     */
    public function getLastSeen(): DateTime
    {
        return $this->lastSeen;
    }

    /**
     * @return string
     */
    public function getSearchKey(): string
    {
        return $this->sourceUrl . '-' . $this->destUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(): ?User
    {
        return $this->getCreatedBy();
    }
}
