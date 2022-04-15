<?php

namespace App\Entities;

use App\Dto\BackLinks\BackLinksRawData;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * ExternalLink
 *
 * @ORM\Table(name="external_links", indexes={@ORM\Index(name="id_imported_urls", columns={"id_imported_urls"})})
 * @ORM\Entity
 */
class ExternalLink
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
     * Imported Url.
     *
     * @var ImportedUrl
     *
     * @ORM\ManyToOne(targetEntity="ImportedUrl")
     *
     * @ORM\JoinColumn(name="id_imported_urls", referencedColumnName="id", nullable=false)
     */
    private ImportedUrl $importedUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dest_url", type="text", length=65535, nullable=true)
     */
    private $destUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=1000, nullable=false)
     */
    private $domain = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="anchortext", type="string", length=1500, nullable=true)
     */
    private $anchorText;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="last_found", type="datetime", nullable=false)
     */
    private $lastFound;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="first_found", type="datetime", nullable=false)
     */
    private $firstFound;

    /**
     * @var int|null
     *
     * @ORM\Column(name="img_text", type="integer", nullable=true)
     */
    private $imgText = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_nofollow", type="boolean", nullable=false)
     */
    private bool $relNofollow = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_sponsored", type="boolean", nullable=false)
     */
    private bool $relSponsored = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_ugc", type="boolean", nullable=false)
     */
    private bool $relUgc = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="found", type="boolean", nullable=false)
     */
    private bool $found = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="js_render", type="boolean", nullable=false)
     */
    private bool $jsRender = false;

    /**
     * @var int|null
     *
     * @ORM\Column(name="respons_code", type="integer", nullable=true)
     */
    private $responseCode = 200;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(name="respons_last_checked", type="datetime", nullable=false)
     */
    private $responseLastChecked;

    /**
     * @var int
     *
     * @ORM\Column(name="redirects", type="integer", nullable=false)
     */
    private $redirects = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="redirect_flow", type="text", length=65535, nullable=true)
     */
    private $redirectFlow;

    /**
     * @var string|null
     *
     * @ORM\Column(name="end_point", type="text", length=65535, nullable=true)
     */
    private $endPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="end_point_domain", type="string", length=1000, nullable=false)
     */
    private $endPointDomain = '';

    /**
     * @param ImportedUrl $importedUrl
     * @param string|null $destUrl
     */
    public function __construct(ImportedUrl $importedUrl, ?string $destUrl)
    {
        $this->importedUrl = $importedUrl;
        $this->destUrl = $destUrl;
        $this->lastFound = Carbon::now();
        $this->firstFound = Carbon::now();
        $this->responseLastChecked = Carbon::now();
    }

    public function fill(BackLinksRawData $data): void
    {
        $fields = $data->getInitializedFields();
        if (in_array(BackLinksRawData::REL_SPONSORED, $fields)) {
            $this->relSponsored = $data->relSponsored;
        }
        if (in_array(BackLinksRawData::REL_NOFOLLOW, $fields)) {
            $this->relNofollow = $data->relNofollow;
        }
        if (in_array(BackLinksRawData::REL_UGC, $fields)) {
            $this->relUgc = $data->relUgc;
        }
        if (in_array(BackLinksRawData::ANCHOR_TEXT, $fields)) {
            $this->anchorText = $data->anchorText;
        }
        if (in_array(BackLinksRawData::IMG_TEXT, $fields)) {
            $this->imgText = $data->imgText ? 1 : 0;
        }
        if (in_array(BackLinksRawData::RESPONSE, $fields)) {
            $this->responseCode = $data->response;
        }
        if (in_array(BackLinksRawData::FIRST_FOUND, $fields)) {
            $this->firstFound = $data->firstFound;
        }
        if (in_array(BackLinksRawData::LAST_FOUND, $fields)) {
            $this->lastFound = $data->lastFound;
        }
    }

    /**
     * @return ImportedUrl
     */
    public function getImportedUrl(): ImportedUrl
    {
        return $this->importedUrl;
    }

    /**
     * @param ImportedUrl $importedUrl
     */
    public function setImportedUrl(ImportedUrl $importedUrl): void
    {
        $this->importedUrl = $importedUrl;
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
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
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
     * @return DateTimeInterface
     */
    public function getLastFound()
    {
        return $this->lastFound;
    }

    /**
     * @param DateTimeInterface $lastFound
     */
    public function setLastFound($lastFound): void
    {
        $this->lastFound = $lastFound;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFirstFound()
    {
        return $this->firstFound;
    }

    /**
     * @param DateTimeInterface $firstFound
     */
    public function setFirstFound($firstFound): void
    {
        $this->firstFound = $firstFound;
    }

    /**
     * @return int|null
     */
    public function getImgText(): ?int
    {
        return $this->imgText;
    }

    /**
     * @param int|null $imgText
     */
    public function setImgText(?int $imgText): void
    {
        $this->imgText = $imgText;
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
     * @return bool
     */
    public function isFound(): bool
    {
        return $this->found;
    }

    /**
     * @param bool $found
     */
    public function setFound(bool $found): void
    {
        $this->found = $found;
    }

    /**
     * @return bool
     */
    public function isJsRender(): bool
    {
        return $this->jsRender;
    }

    /**
     * @param bool $jsRender
     */
    public function setJsRender(bool $jsRender): void
    {
        $this->jsRender = $jsRender;
    }

    /**
     * @return int|null
     */
    public function getResponseCode(): ?int
    {
        return $this->responseCode;
    }

    /**
     * @param int|null $responseCode
     */
    public function setResponseCode(?int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    /**
     * @return DateTimeInterface
     */
    public function getResponseLastChecked()
    {
        return $this->responseLastChecked;
    }

    /**
     * @param DateTimeInterface $responseLastChecked
     */
    public function setResponseLastChecked($responseLastChecked): void
    {
        $this->responseLastChecked = $responseLastChecked;
    }

    /**
     * @return int
     */
    public function getRedirects()
    {
        return $this->redirects;
    }

    /**
     * @param int $redirects
     */
    public function setRedirects($redirects): void
    {
        $this->redirects = $redirects;
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
}
