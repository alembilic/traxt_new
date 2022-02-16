<?php

namespace App\Entities;

use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * ImportedUrl
 *
 * @ORM\Table(name="imported_urls")
 * @ORM\Entity
 */
class ImportedUrl
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=1000, nullable=false)
     */
    private string $url;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_checked", type="datetime", nullable=false)
     */
    private DateTime $lastChecked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="header_noindex", type="boolean", nullable=false)
     */
    private bool $headerNoindex = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="header_nofollow", type="boolean", nullable=false)
     */
    private bool $headerNofollow = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="head_noindex", type="boolean", nullable=false)
     */
    private bool $headNoindex = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="head_nofollow", type="boolean", nullable=false)
     */
    private bool $headNofollow = false;

    /**
     * @var string
     *
     * @ORM\Column(name="respons_code", type="string", length=11, nullable=false)
     */
    private $responseCode = '200';

    /**
     * @var int
     *
     * @ORM\Column(name="index_state", type="integer", nullable=false)
     */
    private $indexState = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nohtml", type="boolean", nullable=false)
     */
    private $nohtml = false;

    /**
     * @var int|null
     *
     * @ORM\Column(name="manual_update_init", type="integer", nullable=true)
     */
    private $manualUpdateInit = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_index_check", type="datetime", nullable=false)
     */
    private DateTime $lastIndexCheck;

    /**
     * @var int
     *
     * @ORM\Column(name="waiting_index_respons", type="integer", nullable=false)
     */
    private $waitingIndexResponse = 0;

    /**
     * @var string|null
     *
     * @ORM\Column(name="redirect_flow", type="text", length=65535, nullable=true)
     */
    private $redirectFlow;

    /**
     * @var string|null
     *
     * @ORM\Column(name="end_point", type="string", length=1000, nullable=true)
     */
    private $endPoint;

    /**
     * @var int
     *
     * @ORM\Column(name="canonical", type="integer", nullable=false)
     */
    private $canonical = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="canonical_endpoint", type="string", length=1000, nullable=false)
     */
    private $canonicalEndpoint = '';

    /**
     * @var int
     *
     * @ORM\Column(name="attempt", type="integer", nullable=false)
     */
    private $attempt = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="index_result_url", type="string", length=1000, nullable=false)
     */
    private $indexResultUrl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="end_point_domain", type="string", length=1000, nullable=false)
     */
    private $endPointDomain = '';

    /**
     * @var string
     *
     * @ORM\Column(name="mem_use", type="string", length=22, nullable=false)
     */
    private $memUse = '';

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->lastChecked = Carbon::now();
        $this->lastIndexCheck = Carbon::now();
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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return DateTime
     */
    public function getLastChecked()
    {
        return $this->lastChecked;
    }

    /**
     * @param DateTime $lastChecked
     */
    public function setLastChecked($lastChecked): void
    {
        $this->lastChecked = $lastChecked;
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
     * @return string
     */
    public function getResponseCode(): string
    {
        return $this->responseCode;
    }

    /**
     * @param string $responseCode
     */
    public function setResponseCode(string $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    /**
     * @return int
     */
    public function getIndexState(): int
    {
        return $this->indexState;
    }

    /**
     * @param int $indexState
     */
    public function setIndexState(int $indexState): void
    {
        $this->indexState = $indexState;
    }

    /**
     * @return bool
     */
    public function isNohtml(): bool
    {
        return $this->nohtml;
    }

    /**
     * @param bool $nohtml
     */
    public function setNohtml(bool $nohtml): void
    {
        $this->nohtml = $nohtml;
    }

    /**
     * @return int|null
     */
    public function getManualUpdateInit(): ?int
    {
        return $this->manualUpdateInit;
    }

    /**
     * @param int|null $manualUpdateInit
     */
    public function setManualUpdateInit(?int $manualUpdateInit): void
    {
        $this->manualUpdateInit = $manualUpdateInit;
    }

    /**
     * @return DateTime
     */
    public function getLastIndexCheck()
    {
        return $this->lastIndexCheck;
    }

    /**
     * @param DateTime $lastIndexCheck
     */
    public function setLastIndexCheck($lastIndexCheck): void
    {
        $this->lastIndexCheck = $lastIndexCheck;
    }

    /**
     * @return int
     */
    public function getWaitingIndexResponse(): int
    {
        return $this->waitingIndexResponse;
    }

    /**
     * @param int $waitingIndexResponse
     */
    public function setWaitingIndexResponse(int $waitingIndexResponse): void
    {
        $this->waitingIndexResponse = $waitingIndexResponse;
    }

    /**
     * @return string|null
     */
    public function getRedirectFlow(): ?string
    {
        return $this->redirectFlow;
    }

    /**
     * @param string|null $redirectFlow
     */
    public function setRedirectFlow(?string $redirectFlow): void
    {
        $this->redirectFlow = $redirectFlow;
    }

    /**
     * @return string|null
     */
    public function getEndPoint(): ?string
    {
        return $this->endPoint;
    }

    /**
     * @param string|null $endPoint
     */
    public function setEndPoint(?string $endPoint): void
    {
        $this->endPoint = $endPoint;
    }

    /**
     * @return int
     */
    public function getCanonical(): int
    {
        return $this->canonical;
    }

    /**
     * @param int $canonical
     */
    public function setCanonical(int $canonical): void
    {
        $this->canonical = $canonical;
    }

    /**
     * @return string
     */
    public function getCanonicalEndpoint(): string
    {
        return $this->canonicalEndpoint;
    }

    /**
     * @param string $canonicalEndpoint
     */
    public function setCanonicalEndpoint(string $canonicalEndpoint): void
    {
        $this->canonicalEndpoint = $canonicalEndpoint;
    }

    /**
     * @return int
     */
    public function getAttempt(): int
    {
        return $this->attempt;
    }

    /**
     * @param int $attempt
     */
    public function setAttempt(int $attempt): void
    {
        $this->attempt = $attempt;
    }

    /**
     * @return string
     */
    public function getIndexResultUrl(): string
    {
        return $this->indexResultUrl;
    }

    /**
     * @param string $indexResultUrl
     */
    public function setIndexResultUrl(string $indexResultUrl): void
    {
        $this->indexResultUrl = $indexResultUrl;
    }

    /**
     * @return string
     */
    public function getEndPointDomain(): string
    {
        return $this->endPointDomain;
    }

    /**
     * @param string $endPointDomain
     */
    public function setEndPointDomain(string $endPointDomain): void
    {
        $this->endPointDomain = $endPointDomain;
    }

    /**
     * @return string
     */
    public function getMemUse(): string
    {
        return $this->memUse;
    }

    /**
     * @param string $memUse
     */
    public function setMemUse(string $memUse): void
    {
        $this->memUse = $memUse;
    }

}
