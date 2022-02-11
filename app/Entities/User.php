<?php

namespace App\Entities;

use App\Contracts\INotifiable;
use App\Entities\Helpers\Notifiable;
use Carbon\Carbon;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="username", columns={"username"})})
 *
 * @ORM\Entity
 */
class User extends Authenticatable implements INotifiable
{
    use Notifiable;

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
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     */
    private string $username;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=40, nullable=false)
     */
    private string $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=40, nullable=false)
     */
    private string $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private ?string $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="api_token", type="string", length=80, nullable=true)
     */
    private ?string $apiToken;

    /**
     * @var int
     *
     * @ORM\Column(name="userlevel", type="integer", nullable=false)
     */
    private int $userLevel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private ?string $email;

    /**
     * @var string
     *
     * @ORM\Column(name="timestamp", type="string", length=50, nullable=false)
     */
    private string $timestamp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="previous_visit", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $previousVisit = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     */
    private string $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="regdate", type="string", length=50, nullable=false)
     */
    private string $regDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastip", type="string", length=15, nullable=true)
     */
    private ?string $lastip;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="user_login_attempts", type="boolean", nullable=true)
     */
    private ?bool $userLoginAttempts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_home_path", type="string", length=50, nullable=true)
     */
    private ?string $userHomePath;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=50, nullable=false)
     */
    private string $company;

    /**
     * @var string
     *
     * @ORM\Column(name="vat_number", type="string", length=25, nullable=false)
     */
    private string $vatNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=false)
     */
    private string $country;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private string $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=75, nullable=false)
     */
    private string $city;

    /**
     * @var int
     *
     * @ORM\Column(name="id_owner", type="integer", nullable=false)
     */
    private int $idOwner = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=45, nullable=false, options={"default"="en-US"})
     */
    private string $lang = 'en-US';

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="string", length=50, nullable=false)
     */
    private string $plan;

    /**
     * @var string
     *
     * @ORM\Column(name="renew", type="string", length=11, nullable=false)
     */
    private string $renew = '';

    /**
     * @var string
     *
     * @ORM\Column(name="sub_id", type="string", length=50, nullable=false)
     */
    private string $subId = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="active_plan", type="boolean", nullable=false)
     */
    private bool $activePlan = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="next_due_date", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $nextDueDate = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="vat_valid", type="string", length=10, nullable=false)
     */
    private string $vatValid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="dinero_add_guid", type="string", length=50, nullable=false)
     */
    private string $dineroAddGuid = '';

    /**
     * @var int
     *
     * @ORM\Column(name="old_user", type="integer", nullable=false)
     */
    private int $oldUser = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="sub_table_id", type="integer", nullable=false)
     */
    private int $subTableId = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="id_valuta", type="integer", nullable=false, options={"default"="31"})
     */
    private int $idValuta = 31;

    /**
     * @var int
     *
     * @ORM\Column(name="id_valuta_display", type="integer", nullable=false, options={"default"="31"})
     */
    private int $idValutaDisplay = 31;

    /**
     * @var int
     *
     * @ORM\Column(name="id_bureau", type="integer", nullable=false)
     */
    private int $idBureau = 0;

    /**
     * Notifications of this user.
     *
     * @ORM\OneToMany(
     *     targetEntity="Notifications",
     *     mappedBy="user",
     *     cascade={"persist"},
     *     indexBy="id"
     * )
     *
     * @var Collection<Notifications>
     */
    private $notifications;

    /**
     * Domains created by this user.
     *
     * @ORM\OneToMany(
     *     targetEntity="Domain",
     *     mappedBy="createdBy",
     *     cascade={"persist"},
     *     indexBy="id"
     * )
     *
     * @var Collection<Domain>
     */
    private $domains;

    /**
     * @return Collection<Notifications>|Notifications[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function isSuperAdmin(): bool
    {
        //TODO: get this value from db
        return false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getUserLevel(): int
    {
        return $this->userLevel;
    }

    /**
     * @param int $userLevel
     */
    public function setUserLevel(int $userLevel): void
    {
        $this->userLevel = $userLevel;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return DateTime|null
     */
    public function getPreviousVisit(): ?DateTime
    {
        return Carbon::createFromTimestamp($this->previousVisit);
    }

    /**
     * @param DateTime|null $previousVisit
     */
    public function setPreviousVisit(?DateTime $previousVisit): void
    {
        $this->previousVisit = $previousVisit->getTimestamp();
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return DateTime
     */
    public function getRegDate(): DateTime
    {
        return Carbon::createFromTimestamp($this->regDate);
    }

    /**
     * @param DateTime $regDate
     */
    public function setRegDate(DateTime $regDate): void
    {
        $this->regDate = $regDate->getTimestamp();
    }

    /**
     * @return string|null
     */
    public function getLastip(): ?string
    {
        return $this->lastip;
    }

    /**
     * @param string|null $lastip
     */
    public function setLastip(?string $lastip): void
    {
        $this->lastip = $lastip;
    }

    /**
     * @return bool|null
     */
    public function getUserLoginAttempts(): ?bool
    {
        return $this->userLoginAttempts;
    }

    /**
     * @param bool|null $userLoginAttempts
     */
    public function setUserLoginAttempts(?bool $userLoginAttempts): void
    {
        $this->userLoginAttempts = $userLoginAttempts;
    }

    /**
     * @return string|null
     */
    public function getUserHomePath(): ?string
    {
        return $this->userHomePath;
    }

    /**
     * @param string|null $userHomePath
     */
    public function setUserHomePath(?string $userHomePath): void
    {
        $this->userHomePath = $userHomePath;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     */
    public function setVatNumber(string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getIdOwner(): int
    {
        return $this->idOwner;
    }

    /**
     * @param int $idOwner
     */
    public function setIdOwner(int $idOwner): void
    {
        $this->idOwner = $idOwner;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getPlan(): string
    {
        return $this->plan;
    }

    /**
     * @param string $plan
     */
    public function setPlan(string $plan): void
    {
        $this->plan = $plan;
    }

    /**
     * @return string
     */
    public function getRenew(): string
    {
        return $this->renew;
    }

    /**
     * @param string $renew
     */
    public function setRenew(string $renew): void
    {
        $this->renew = $renew;
    }

    /**
     * @return string
     */
    public function getSubId(): string
    {
        return $this->subId;
    }

    /**
     * @param string $subId
     */
    public function setSubId(string $subId): void
    {
        $this->subId = $subId;
    }

    /**
     * @return bool
     */
    public function isActivePlan(): bool
    {
        return $this->activePlan;
    }

    /**
     * @param bool $activePlan
     */
    public function setActivePlan(bool $activePlan): void
    {
        $this->activePlan = $activePlan;
    }

    /**
     * @return DateTime
     */
    public function getNextDueDate()
    {
        return $this->nextDueDate;
    }

    /**
     * @param DateTime $nextDueDate
     */
    public function setNextDueDate($nextDueDate): void
    {
        $this->nextDueDate = $nextDueDate;
    }

    /**
     * @return string
     */
    public function getVatValid(): string
    {
        return $this->vatValid;
    }

    /**
     * @param string $vatValid
     */
    public function setVatValid(string $vatValid): void
    {
        $this->vatValid = $vatValid;
    }

    /**
     * @return string
     */
    public function getDineroAddGuid(): string
    {
        return $this->dineroAddGuid;
    }

    /**
     * @param string $dineroAddGuid
     */
    public function setDineroAddGuid(string $dineroAddGuid): void
    {
        $this->dineroAddGuid = $dineroAddGuid;
    }

    /**
     * @return int
     */
    public function getOldUser(): int
    {
        return $this->oldUser;
    }

    /**
     * @param int $oldUser
     */
    public function setOldUser(int $oldUser): void
    {
        $this->oldUser = $oldUser;
    }

    /**
     * @return int
     */
    public function getSubTableId(): int
    {
        return $this->subTableId;
    }

    /**
     * @param int $subTableId
     */
    public function setSubTableId(int $subTableId): void
    {
        $this->subTableId = $subTableId;
    }

    /**
     * @return int
     */
    public function getIdValuta(): int
    {
        return $this->idValuta;
    }

    /**
     * @param int $idValuta
     */
    public function setIdValuta(int $idValuta): void
    {
        $this->idValuta = $idValuta;
    }

    /**
     * @return int
     */
    public function getIdValutaDisplay(): int
    {
        return $this->idValutaDisplay;
    }

    /**
     * @param int $idValutaDisplay
     */
    public function setIdValutaDisplay(int $idValutaDisplay): void
    {
        $this->idValutaDisplay = $idValutaDisplay;
    }

    /**
     * @return int
     */
    public function getIdBureau(): int
    {
        return $this->idBureau;
    }

    /**
     * @param int $idBureau
     */
    public function setIdBureau(int $idBureau): void
    {
        $this->idBureau = $idBureau;
    }

    /**
     * @return Collection
     */
    public function getDomains(): Collection
    {
        return $this->domains->matching(Criteria::create()->where(Criteria::expr()->eq('deleted', 0)));
    }
}
