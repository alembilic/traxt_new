<?php

namespace App\Entities;

use App\Contracts\IHasUser;
use App\Jobs\CreateDomainThumbJob;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Doctrine\Common\Collections\Collection;

/**
 * Domain
 *
 * @ORM\Table(name="trx_domains")
 *
 * @ORM\Entity()
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Domain implements IHasUser
{
    use Timestamps;

    public const ID = 'id';
    public const USER = 'createdBy';
    public const DELETED = 'deleted';
    public const DOMAIN_URL = 'domainUrl';

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
     * @ORM\Column(name="domain_name", type="string", length=191, nullable=false)
     */
    private string $domainName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain_url", type="string", length=191, nullable=true)
     */
    private ?string $domainUrl = null;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain_alias", type="string", length=100, nullable=true)
     */
    private ?string $domainAlias = null;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=false)
     */
    private int $parentId = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_type", type="string", length=191, nullable=false)
     */
    private string $domainType;

    /**
     * User whose created this domain.
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
     * @var string|null
     *
     * @ORM\Column(name="thumb_url", type="string", length=100, nullable=true)
     */
    private ?string $thumbUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="domain_status", type="boolean", nullable=false, options={"default"="1"})
     */
    private bool $domainStatus = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_dash", type="boolean", nullable=false)
     */
    private bool $showDash = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private bool $deleted = false;

    /**
     * @var int
     *
     * @ORM\Column(name="validate", type="integer", nullable=false, options={"default"="1"})
     */
    private int $validate = 1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="respons_code", type="integer", nullable=true)
     */
    private ?int $responseCode = null;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_end_point", type="string", length=1000, nullable=false)
     */
    private string $domainEndPoint = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain_redirect_flow", type="text", length=65535, nullable=true)
     */
    private ?string $domainRedirectFlow = null;

    /**
     * User Suppliers Settings.
     *
     * @ORM\OneToMany(
     *     targetEntity="BackLink",
     *     mappedBy="domain",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     *
     * @var Collection<BackLink>
     */
    private Collection $backLinks;

    /**
     * @param string $domainName url
     * @param User $user user
     */
    public function __construct(string $domainName, User $user)
    {
        $this->domainName = $domainName;
        $this->createdBy = $user;
        $this->backLinks = new ArrayCollection();
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
    public function getDomainName(): string
    {
        return $this->domainName;
    }

    /**
     * @param string $domainName
     */
    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }

    /**
     * @return string|null
     */
    public function getDomainUrl(): ?string
    {
        return $this->domainUrl;
    }

    /**
     * @param string|null $domainUrl
     */
    public function setDomainUrl(?string $domainUrl): void
    {
        $this->domainUrl = $domainUrl;
    }

    /**
     * @return string|null
     */
    public function getDomainAlias(): ?string
    {
        return $this->domainAlias;
    }

    /**
     * @param string|null $domainAlias
     */
    public function setDomainAlias(?string $domainAlias): void
    {
        $this->domainAlias = $domainAlias;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getDomainType(): string
    {
        return $this->domainType;
    }

    /**
     * @param string $domainType
     */
    public function setDomainType(string $domainType): void
    {
        $this->domainType = $domainType;
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
     * @return string|null
     */
    public function getThumbUrl(): ?string
    {
        return $this->thumbUrl;
    }

    /**
     * @param string|null $thumbUrl
     */
    public function setThumbUrl(?string $thumbUrl): void
    {
        $this->thumbUrl = $thumbUrl;
    }

    /**
     * @return bool
     */
    public function isDomainStatus(): bool
    {
        return $this->domainStatus;
    }

    /**
     * @param bool $domainStatus
     */
    public function setDomainStatus(bool $domainStatus): void
    {
        $this->domainStatus = $domainStatus;
    }

    /**
     * @return bool
     */
    public function isShowDash(): bool
    {
        return $this->showDash;
    }

    /**
     * @param bool $showDash
     */
    public function setShowDash(bool $showDash): void
    {
        $this->showDash = $showDash;
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
    public function getValidate(): int
    {
        return $this->validate;
    }

    /**
     * @param int $validate
     */
    public function setValidate(int $validate): void
    {
        $this->validate = $validate;
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
     * @return string
     */
    public function getDomainEndPoint(): string
    {
        return $this->domainEndPoint;
    }

    /**
     * @param string $domainEndPoint
     */
    public function setDomainEndPoint(string $domainEndPoint): void
    {
        $this->domainEndPoint = $domainEndPoint;
    }

    /**
     * @return string|null
     */
    public function getDomainRedirectFlow(): ?string
    {
        return $this->domainRedirectFlow;
    }

    /**
     * @param string|null $domainRedirectFlow
     */
    public function setDomainRedirectFlow(?string $domainRedirectFlow): void
    {
        $this->domainRedirectFlow = $domainRedirectFlow;
    }

    /**
     * @return Collection
     */
    public function getBackLinks(): Collection
    {
        return $this->backLinks;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(): ?User
    {
        return $this->getCreatedBy();
    }

    /**
     * @ORM\PostPersist()
     */
    public function createThumb(): void
    {
        if (!$this->thumbUrl) {
            dispatch(new CreateDomainThumbJob($this));
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeThumb(): void
    {
        if ($this->thumbUrl && file_exists(public_path() . $this->thumbUrl)) {
            unlink(public_path() . $this->thumbUrl);
        }
    }
}
