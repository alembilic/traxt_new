<?php

namespace App\Entities;

use App\Dto\BackLinksRawData;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * TrxBackLink
 *
 * @ORM\Table(name="trx_backlinks")
 * @ORM\Entity
 */
class TrxBackLink
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
     * @var string
     *
     * @ORM\Column(name="source_url", type="string", length=191, nullable=false)
     */
    private string $sourceUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dest_url", type="string", length=191, nullable=true)
     */
    private $destUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = 0;

    /**
     * @var string|null
     *
     * @ORM\Column(name="anchortext", type="string", length=191, nullable=true)
     */
    private $anchorText;

    /**
     * User whose created this link.
     *
     * @var User|null
     *
     * @Gedmo\Blameable(on="create")
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

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
     * @var DateTime
     *
     * @ORM\Column(name="last_checked", type="datetime", nullable=false)
     */
    private $lastChecked;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_found", type="datetime", nullable=false)
     */
    private $lastFound;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="first_found", type="datetime", nullable=false)
     */
    private $firstFound;

    /**
     * @var int
     *
     * @ORM\Column(name="link_type", type="integer", nullable=false)
     */
    private $linkType = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="ignore_link", type="boolean", nullable=false)
     */
    private bool $relNoindex = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tld_name", type="string", length=100, nullable=true)
     */
    private $tldName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link_tld", type="string", length=100, nullable=true)
     */
    private $linkTld;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private bool $deleted = false;

    /**
     * Values 0-2.
     *
     * @var int
     *
     * @ORM\Column(name="img_text", type="integer", nullable=false)
     */
    private int $imgText = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="header_noindex", type="boolean", nullable=false)
     */
    private bool $headerNoindex = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="header_nofollow", type="boolean", nullable=false)
     */
    private bool $headerNofollow = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="head_noindex", type="boolean", nullable=false)
     */
    private bool $headNoindex = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="head_nofollow", type="boolean", nullable=false)
     */
    private bool $headNofollow = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="rel_nofollow", type="boolean", nullable=false)
     */
    private bool $relNofollow = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="rel_sponsored", type="boolean", nullable=false)
     */
    private bool $relSponsored = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="rel_ugc", type="boolean", nullable=false)
     */
    private bool $relUgc = false;

    /**
     * @var int
     *
     * @ORM\Column(name="respons", type="integer", length=3, nullable=false)
     */
    private int $response = 200;

    /**
     * @param string $sourceUrl source
     * @param Domain $domain related Domain
     */
    public function __construct(string $sourceUrl, Domain $domain)
    {
        $this->sourceUrl = $sourceUrl;
        $this->domain = $domain;
        $this->firstFound = new DateTime();
        $this->lastFound = new DateTime();
        $this->lastChecked = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }

    /**
     * @param string $sourceUrl
     */
    public function setSourceUrl(string $sourceUrl): void
    {
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @return string|null
     */
    public function getDestUrl(): ?string
    {
        return $this->destUrl;
    }

    /**
     * @param string|null $destUrl
     */
    public function setDestUrl(?string $destUrl): void
    {
        $this->destUrl = $destUrl;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getAnchorText(): ?string
    {
        return $this->anchorText;
    }

    /**
     * @param string|null $anchorText
     */
    public function setAnchorText(?string $anchorText): void
    {
        $this->anchorText = $anchorText;
    }

    /**
     * @return User|null
     */
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    /**
     * @param User|null $createdBy
     */
    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return $this->domain;
    }

    /**
     * @param Domain $domain
     */
    public function setDomain(Domain $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return DateTime
     */
    public function getLastChecked(): DateTime
    {
        return $this->lastChecked;
    }

    /**
     * @param DateTime $lastChecked
     */
    public function setLastChecked(DateTime $lastChecked): void
    {
        $this->lastChecked = $lastChecked;
    }

    /**
     * @return DateTime
     */
    public function getLastFound(): DateTime
    {
        return $this->lastFound;
    }

    /**
     * @param DateTime $lastFound
     */
    public function setLastFound(DateTime $lastFound): void
    {
        $this->lastFound = $lastFound;
    }

    /**
     * @return DateTime
     */
    public function getFirstFound(): DateTime
    {
        return $this->firstFound;
    }

    /**
     * @param DateTime $firstFound
     */
    public function setFirstFound(DateTime $firstFound): void
    {
        $this->firstFound = $firstFound;
    }

    /**
     * @return int
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * @param int $linkType
     */
    public function setLinkType($linkType): void
    {
        $this->linkType = $linkType;
    }

    /**
     * @return bool
     */
    public function isRelNoindex(): bool
    {
        return $this->relNoindex;
    }

    /**
     * @param bool $relNoindex
     */
    public function setRelNoindex(bool $relNoindex): void
    {
        $this->relNoindex = $relNoindex;
    }

    /**
     * @return string|null
     */
    public function getTldName(): ?string
    {
        return $this->tldName;
    }

    /**
     * @param string|null $tldName
     */
    public function setTldName(?string $tldName): void
    {
        $this->tldName = $tldName;
    }

    /**
     * @return string|null
     */
    public function getLinkTld(): ?string
    {
        return $this->linkTld;
    }

    /**
     * @param string|null $linkTld
     */
    public function setLinkTld(?string $linkTld): void
    {
        $this->linkTld = $linkTld;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return int
     */
    public function getImgText(): int
    {
        return $this->imgText;
    }

    /**
     * @param int $imgText
     */
    public function setImgText(int $imgText): void
    {
        $this->imgText = $imgText;
    }

    /**
     * @return bool
     */
    public function isHeaderNoindex(): bool
    {
        return $this->headerNoindex;
    }

    /**
     * @param bool $headerNoindex
     */
    public function setHeaderNoindex(bool $headerNoindex): void
    {
        $this->headerNoindex = $headerNoindex;
    }

    /**
     * @return bool
     */
    public function isHeaderNofollow(): bool
    {
        return $this->headerNofollow;
    }

    /**
     * @param bool $headerNofollow
     */
    public function setHeaderNofollow(bool $headerNofollow): void
    {
        $this->headerNofollow = $headerNofollow;
    }

    /**
     * @return bool
     */
    public function isHeadNoindex(): bool
    {
        return $this->headNoindex;
    }

    /**
     * @param bool $headNoindex
     */
    public function setHeadNoindex(bool $headNoindex): void
    {
        $this->headNoindex = $headNoindex;
    }

    /**
     * @return bool
     */
    public function isHeadNofollow(): bool
    {
        return $this->headNofollow;
    }

    /**
     * @param bool $headNofollow
     */
    public function setHeadNofollow(bool $headNofollow): void
    {
        $this->headNofollow = $headNofollow;
    }

    /**
     * @return bool
     */
    public function isRelNofollow(): bool
    {
        return $this->relNofollow;
    }

    /**
     * @param bool $relNofollow
     */
    public function setRelNofollow(bool $relNofollow): void
    {
        $this->relNofollow = $relNofollow;
    }

    /**
     * @return bool
     */
    public function isRelSponsored(): bool
    {
        return $this->relSponsored;
    }

    /**
     * @param bool $relSponsored
     */
    public function setRelSponsored(bool $relSponsored): void
    {
        $this->relSponsored = $relSponsored;
    }

    /**
     * @return bool
     */
    public function isRelUgc(): bool
    {
        return $this->relUgc;
    }

    /**
     * @param bool $relUgc
     */
    public function setRelUgc(bool $relUgc): void
    {
        $this->relUgc = $relUgc;
    }

    /**
     * @return int
     */
    public function getResponse(): int
    {
        return $this->response;
    }

    /**
     * @param int $response
     */
    public function setResponse(int $response): void
    {
        $this->response = $response;
    }

    public function fill(BackLinksRawData $data): void
    {
        $fields = $data->getInitializedFields();
        if (in_array(BackLinksRawData::REL_SPONSORED, $fields)) {
            $this->relSponsored = $data->relSponsored;
        }
        if (in_array(BackLinksRawData::REL_NOINDEX, $fields)) {
            $this->relNoindex = $data->relNoindex;
        }
        if (in_array(BackLinksRawData::REL_NOFOLLOW, $fields)) {
            $this->relNofollow = $data->relNofollow;
        }
        if (in_array(BackLinksRawData::REL_UGC, $fields)) {
            $this->relUgc = $data->relUgc;
        }
        if (in_array(BackLinksRawData::HEAD_NOFOLLOW, $fields)) {
            $this->headNofollow = $data->headNofollow;
        }
        if (in_array(BackLinksRawData::HEAD_NOINDEX, $fields)) {
            $this->headNoindex = $data->headNoindex;
        }
        if (in_array(BackLinksRawData::HEADER_NOFOLLOW, $fields)) {
            $this->headerNofollow = $data->headerNofollow;
        }
        if (in_array(BackLinksRawData::HEADER_NOINDEX, $fields)) {
            $this->headerNoindex = $data->headerNoindex;
        }
        if (in_array(BackLinksRawData::ANCHOR_TEXT, $fields)) {
            $this->anchorText = $data->anchorText;
        }
        if (in_array(BackLinksRawData::IMG_TEXT, $fields)) {
            $this->imgText = $data->imgText ? 1 : 0;
        }
        if (in_array(BackLinksRawData::RESPONSE, $fields)) {
            $this->response = $data->response;
        }
        if (in_array(BackLinksRawData::FIRST_FOUND, $fields)) {
            $this->firstFound = $data->firstFound;
        }
        if (in_array(BackLinksRawData::LAST_FOUND, $fields)) {
            $this->lastFound = $data->lastFound;
        }
        if (in_array(BackLinksRawData::LAST_CHECKED, $fields)) {
            $this->lastChecked = $data->lastChecked;
        }
        if (in_array(BackLinksRawData::DEST_URL, $fields)) {
            $this->destUrl = $data->destUrl;
        }
        if (in_array(BackLinksRawData::TLD_LINK, $fields)) {
            $this->linkTld = $data->tldLink;
        }
        if (in_array(BackLinksRawData::TLD_NAME, $fields)) {
            $this->tldName = $data->tldName;
        }
        if (in_array(BackLinksRawData::LINK_TYPE, $fields)) {
            $this->linkType = (int)$data->linkType;
        }
        if (in_array(BackLinksRawData::STATUS, $fields)) {
            $this->status = (int)($data->status ?? 1);
        }
    }
}
