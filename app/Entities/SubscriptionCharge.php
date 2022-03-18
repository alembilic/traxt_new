<?php

namespace App\Entities;

use App\Enums\ChargeStatuses;
use App\Jobs\AccountingSystemPaymentJob;
use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * Subscription Charges
 *
 * @ORM\Table(name="subscriptions_charges")
 *
 * @ORM\Entity()
 *
 * @ORM\HasLifecycleCallbacks()
 */
class SubscriptionCharge
{
    use Timestamps;

    public const STATUS = 'status';
    public const USER = 'createdBy';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(targetEntity="Subscription")
     *
     * @ORM\JoinColumn(name="subscriptions_id", referencedColumnName="id")
     */
    private Subscription $subscription;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private User $createdBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private int $amount = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="vat", type="integer", nullable=false)
     */
    private int $vat = 0;

    /**
     * @var string|null
     *
     * @ORM\Column(name="accounting_system_id", type="string", nullable=true)
     */
    private ?string $accountingSystemId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="external_id", type="string", nullable=true)
     */
    private ?string $externalId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private string $status = ChargeStatuses::PENDING;

    /**
     * @param Subscription $subscription
     * @param float $amount
     * @param float $vat
     */
    public function __construct(Subscription $subscription, float $amount, float $vat)
    {
        $this->subscription = $subscription;
        $this->amount = intval($amount * 100);
        $this->vat = intval($vat * 100);
        $this->subscription = $subscription;
        $this->createdBy = $subscription->getCreatedBy();
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     */
    public function setSubscription(Subscription $subscription): void
    {
        $this->subscription = $subscription;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount / 100;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = round($amount * 100);
    }

    /**
     * @return float
     */
    public function getVat(): float
    {
        return $this->vat / 100;
    }

    /**
     * @param float $vat
     */
    public function setVat(float $vat): void
    {
        $this->vat = round($vat * 100);
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getAmount() + $this->getVat();
    }

    /**
     * @return string|null
     */
    public function getAccountingSystemId(): ?string
    {
        return $this->accountingSystemId;
    }

    /**
     * @param string|null $accountingSystemId
     */
    public function setAccountingSystemId(?string $accountingSystemId): void
    {
        $this->accountingSystemId = $accountingSystemId;
    }

    /**
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @param string|null $externalId
     */
    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param Carbon $updatedAt
     */
    public function setUpdatedAt(Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     */
    public function setCreatedBy(User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @ORM\PostPersist()
     */
    public function accountingSystemIntegration(): void
    {
        dispatch(new AccountingSystemPaymentJob($this));
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function addActivityAfterValueChange(LifecycleEventArgs $args): void
    {
        $em = $args->getEntityManager();
        $changeSet = $em->getUnitOfWork()->getEntityChangeSet($this);

        if (isset($changeSet[static::STATUS]) && $changeSet[static::STATUS][1] === ChargeStatuses::COMPLETE) {
            $subscription = $this->getSubscription();
            $subscription->activate();
            $subscription->setNextDueDate(Carbon::now()->startOfDay()->addMonths($subscription->getPeriod()));
            $em->persist($subscription);
            $em->flush();
        }
    }
}
