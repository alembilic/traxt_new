<?php

namespace App\Entities;

use App\Core\EntityManagerFresher;
use App\Dto\SubscriptionData;
use App\Enums\SubscriptionTypes;
use App\Jobs\TerminateSubscriptionJob;
use Carbon\Carbon;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * Subscription
 *
 * @ORM\Table(name="subscriptions")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 *
 * @ORM\Entity
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Subscription
{
    use EntityManagerFresher;
    use Timestamps;
    use SoftDeleteable;

    public const ID = 'id';
    public const CREATED_BY = 'createdBy';
    public const NEXT_DUE_DATE = 'nextDueDate';
    public const PRODUCT = 'product';
    public const CANCEL_DATE = 'cancelDate';
    public const ACTIVE = 'active';
    public const PAYMENT_PERIOD = 'paymentPeriod';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="external_id", type="string", nullable=false)
     */
    private string $externalId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_url", type="string", nullable=true)
     */
    private ?string $paymentUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="accounting_system_id", type="string", nullable=true)
     */
    private ?string $accountingSystemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="payment_period", type="integer", nullable=false)
     */
    private int $paymentPeriod;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="cancel_date", type="datetime", nullable=true)
     */
    private ?DateTime $cancelDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="next_due_date", type="date", nullable=false)
     */
    private DateTime $nextDueDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private bool $active = false;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_system", type="string", length=50, nullable=false)
     */
    private string $paymentSystem;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     *
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private Product $product;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="subscription")
     *
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private User $createdBy;

    /**
     * @param User $user User
     * @param Product $product Product
     * @param int $paymentPeriod
     * @param string|null $system payment system
     */
    public function __construct(User $user, Product $product, int $paymentPeriod = 1, ?string $system = 'quickPay')
    {
        $this->createdBy = $user;
        $this->product = $product;
        $this->paymentPeriod = $paymentPeriod;
        $this->paymentSystem = $system;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
        $this->nextDueDate = Carbon::now();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function fill(SubscriptionData $data): void
    {
        $fields = $data->getInitializedFields();
        if (in_array(SubscriptionData::EXTERNAL_ID, $fields)) {
            $this->externalId = (string)$data->externalId;
        }
        if (in_array(SubscriptionData::PAYMENT_URL, $fields)) {
            $this->paymentUrl = (string)$data->paymentUrl;
        }
        if (in_array(SubscriptionData::ACCOUNTING_SYSTEM_ID, $fields)) {
            $this->accountingSystemId = (string)$data->accountingSystemId;
        }
        if (in_array(SubscriptionData::PAYMENT_PERIOD, $fields)) {
            $this->paymentPeriod = $data->paymentPeriod;
        }
        if (in_array(SubscriptionData::NEXT_DUE_DATE, $fields)) {
            $this->nextDueDate = $data->nextDueDate;
        }
        if (in_array(SubscriptionData::CANCEL_DATE, $fields)) {
            $this->cancelDate = $data->cancelDate;
        }
        if (in_array(SubscriptionData::ACTIVE, $fields)) {
            $this->active = $data->active;
        }
        $this->updatedAt = Carbon::now();
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @return string|null
     */
    public function getPaymentUrl(): ?string
    {
        return $this->paymentUrl;
    }

    /**
     * @param string $externalId
     */
    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @param string|null $paymentUrl
     */
    public function setPaymentUrl(?string $paymentUrl): void
    {
        $this->paymentUrl = $paymentUrl;
    }

    /**
     * @param string|null $accountingSystemId
     */
    public function setAccountingSystemId(?string $accountingSystemId): void
    {
        $this->accountingSystemId = $accountingSystemId;
    }

    /**
     * @param DateTime|null $cancelDate
     */
    public function setCancelDate(?DateTime $cancelDate): void
    {
        $this->cancelDate = $cancelDate;
    }

    /**
     * @return string|null
     */
    public function getAccountingSystemId(): ?string
    {
        return $this->accountingSystemId;
    }

    /**
     * @return int
     */
    public function getPaymentPeriod(): int
    {
        return $this->paymentPeriod;
    }

    /**
     * @return DateTime|null
     */
    public function getCancelDate(): ?DateTime
    {
        return $this->cancelDate;
    }

    /**
     * @return DateTime
     */
    public function getNextDueDate(): DateTime
    {
        return $this->nextDueDate;
    }

    /**
     * @param DateTime $nextDueDate
     */
    public function setNextDueDate(DateTime $nextDueDate): void
    {
        $this->nextDueDate = $nextDueDate;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return void
     */
    public function activate(): void
    {
        $this->active = true;
    }

    /**
     * @return void
     */
    public function deactivate(): void
    {
        $this->active = false;
        $this->cancelDate = new DateTime();
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->paymentPeriod === 1 ? SubscriptionTypes::MONTHLY : SubscriptionTypes::YEARLY;
    }

    /**
     * @return integer
     */
    public function getPeriod(): int
    {
        if (!$this->getProduct()) {
            return 0;
        }
        return $this->getType() === SubscriptionTypes::MONTHLY
            ? $this->getProduct()->getRenew()
            : $this->getProduct()->getRenewSubscribe();
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        $product = $this->getProduct();
        if (!$product) {
            return 0.00;
        }

        return ($this->getType() === SubscriptionTypes::MONTHLY
                ? $product->getPricePerMonth()
                : $product->getPricePeriod()) / 100;
    }

    /**
     * @return float
     */
    public function getVat(): float
    {
        $product = $this->getProduct();
        if (!$product) {
            return 0.00;
        }

        if (!$this->createdBy->getVatValid() || $this->createdBy->getVatValid() === 'DK') {
            return ($this->getType() === SubscriptionTypes::MONTHLY
                    ? $product->getPricePerMonth()
                    : $product->getPricePeriod()) / 100 * 0.25;
        }

        return 0;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getPrice() + $this->getVat();
    }

    /**
     * Cancel all current subscriptions.
     *
     * @ORM\PostUpdate()
     */
    public function terminateSubscription(LifecycleEventArgs $args): void
    {
        $changeSet = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($this);

        if ($this->getPrice() && isset($changeSet[static::CANCEL_DATE]) && $changeSet[static::CANCEL_DATE][1]) {
            dispatch(new TerminateSubscriptionJob($this));
        }
    }

    /**
     * Deactivate all subscriptions except current.
     *
     * @ORM\PostUpdate()
     */
    public function onActivateSubscription(LifecycleEventArgs $args): void
    {
        $em = $args->getEntityManager();
        $changeSet = $em->getUnitOfWork()->getEntityChangeSet($this);

        if (isset($changeSet[static::ACTIVE]) && $changeSet[static::ACTIVE][1]) {
            $user = $this->getCreatedBy();
            $user->setNextDueDate($this->getNextDueDate());
            $user->setActivePlan(true);
            $user->setOldUser(1);
            $user->setPlan($this->getProduct()->getMixId());
            $user->setRenew(1);
            $em->persist($user);

            $subscriptions = $em->getRepository(Subscription::class)->matching(Criteria::create()
                ->where(Criteria::expr()->eq(Subscription::CREATED_BY, $this->getCreatedBy()))
                ->andWhere(Criteria::expr()->isNull(Subscription::CANCEL_DATE))
                ->andWhere(Criteria::expr()->gt(Subscription::NEXT_DUE_DATE, (new DateTime())))
                ->andWhere(Criteria::expr()->eq(Subscription::ACTIVE, true))
                ->andWhere(Criteria::expr()->neq(Subscription::ID, $this->getId()))
            );
            /* @var Subscription $subscription */
            foreach ($subscriptions as $subscription) {
                $subscription->deactivate();
                $em->persist($subscription);
            }
            $em->flush();
        }
    }
}
