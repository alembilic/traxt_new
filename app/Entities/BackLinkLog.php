<?php

namespace App\Entities;

use App\Dto\BackLinks\BackLinksRawData;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * BackLinkLog
 *
 * @ORM\Table(name="backlinks_logs")
 *
 * @ORM\Entity
 */
class BackLinkLog
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
     * Backlink.
     *
     * @var BackLink
     *
     * @ORM\ManyToOne(targetEntity="BackLink")
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
     * @var boolean
     *
     * @ORM\Column(name="nofollow", type="boolean", nullable=false)
     */
    private bool $nofollow = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="alt", type="boolean", nullable=false)
     */
    private bool $alt = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="anchor", type="boolean", nullable=false)
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
     * @var integer|null
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private ?int $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="spam_score", type="integer", nullable=false)
     */
    private int $spamScore = 0;

    /**
     * @param BackLink $backLink Back Link
     * @param string $data payload
     */
    public function __construct(BackLink $backLink, string $data)
    {
        $this->data = $data;
        $this->backLink = $backLink;
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
        if (in_array(BackLinksRawData::SPAM_SCORE, $fields)) {
            $this->spamScore = (int)$data->spamScore;
        }
    }

    /**
     * @return BackLink
     */
    public function getBackLink(): BackLink
    {
        return $this->backLink;
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
}
