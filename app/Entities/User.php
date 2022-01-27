<?php

namespace App\Entities;

use App\Contracts\INotifiable;
use App\Entities\Helpers\Notifiable;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="username", columns={"username"})})
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
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=40, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=40, nullable=false)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="userlevel", type="boolean", nullable=false)
     */
    private $userlevel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="timestamp", type="string", length=50, nullable=false)
     */
    private $timestamp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="previous_visit", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $previousVisit = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="regdate", type="string", length=50, nullable=false)
     */
    private $regdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastip", type="string", length=15, nullable=true)
     */
    private $lastip;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="user_login_attempts", type="boolean", nullable=true)
     */
    private $userLoginAttempts;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_home_path", type="string", length=50, nullable=true)
     */
    private $userHomePath;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=50, nullable=false)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="vat_number", type="string", length=25, nullable=false)
     */
    private $vatNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=75, nullable=false)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="id_owner", type="integer", nullable=false)
     */
    private $idOwner = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=45, nullable=false, options={"default"="en-US"})
     */
    private $lang = 'en-US';

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="string", length=50, nullable=false)
     */
    private $plan;

    /**
     * @var string
     *
     * @ORM\Column(name="renew", type="string", length=11, nullable=false)
     */
    private $renew = '';

    /**
     * @var string
     *
     * @ORM\Column(name="sub_id", type="string", length=50, nullable=false)
     */
    private $subId = '';

    /**
     * @var int
     *
     * @ORM\Column(name="active_plan", type="integer", nullable=false)
     */
    private $activePlan = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_due_date", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $nextDueDate = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="vat_valid", type="string", length=10, nullable=false)
     */
    private $vatValid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="dinero_add_guid", type="string", length=50, nullable=false)
     */
    private $dineroAddGuid = '';

    /**
     * @var int
     *
     * @ORM\Column(name="old_user", type="integer", nullable=false)
     */
    private $oldUser = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="sub_table_id", type="integer", nullable=false)
     */
    private $subTableId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="id_valuta", type="integer", nullable=false, options={"default"="31"})
     */
    private $idValuta = 31;

    /**
     * @var int
     *
     * @ORM\Column(name="id_valuta_display", type="integer", nullable=false, options={"default"="31"})
     */
    private $idValutaDisplay = 31;

    /**
     * @var int
     *
     * @ORM\Column(name="id_bureau", type="integer", nullable=false)
     */
    private $idBureau = '0';

    public function isSuperAdmin(): bool
    {
        //TODO: get this value from db
        return false;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
