<?php

namespace App\Entities;

use App\Contracts\IEntity;
use App\Core\EntityManagerFresher;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Order
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity
 */
class Order implements IEntity
{
    use EntityManagerFresher;

    public const ID = 'id';
    public const USER = 'user';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     *
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="subscriptions_orders_id", type="string", length=50, nullable=false)
     */
    private $orderSubscription;

    /**
     * Product.
     *
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=50, nullable=false)
     */
    private $product;

    /**
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private int $amount;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="next_payment_date", type="date", nullable=false)
     */
    private $nextPaymentDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="card_withdraw", type="integer", nullable=true)
     */
    private ?int $cardWithdraw = 0;

    /**
     * @var int
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="transfer_state", type="integer", nullable=false)
     */
    private int $transferState = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="vat", type="integer", nullable=false)
     */
    private int $vat = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="dinero_guid", type="string", length=50, nullable=false)
     */
    private $dineroGuid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="dinero_timestamp", type="string", length=50, nullable=false)
     */
    private $dineroTimestamp = '';

    /**
     * Invoice constructor.
     *
     * @param User $user User
     * @param Product $product Product
     */
    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getOrderSubscription(): string
    {
        return $this->orderSubscription;
    }

    /**
     * @param string $orderSubscription
     */
    public function setOrderSubscription(string $orderSubscription): void
    {
        $this->orderSubscription = $orderSubscription;
    }

    /**
     * @return Product
     *
     * @throws BindingResolutionException
     */
    public function getProduct(): Product
    {
        return $this->getEntityManager()->getRepository(Product::class)->findOneBy(['mixId' => $this->product]);
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product->getMixId();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return round($this->vat / 100, 2);
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = round($amount * 100);
    }

    /**
     * @return DateTime
     */
    public function getNextPaymentDate(): DateTime
    {
        return $this->nextPaymentDate;
    }

    /**
     * @param DateTime $nextPaymentDate
     */
    public function setNextPaymentDate(DateTime $nextPaymentDate): void
    {
        $this->nextPaymentDate = $nextPaymentDate;
    }

    /**
     * @return int|null
     */
    public function getCardWithdraw(): ?int
    {
        return $this->cardWithdraw;
    }

    /**
     * @param int|null $cardWithdraw
     */
    public function setCardWithdraw(?int $cardWithdraw): void
    {
        $this->cardWithdraw = $cardWithdraw;
    }

    /**
     * @return int
     */
    public function getTransferState(): int
    {
        return $this->transferState;
    }

    /**
     * @param int $transferState
     */
    public function setTransferState(int $transferState): void
    {
        $this->transferState = $transferState;
    }

    /**
     * @return float
     */
    public function getVat(): float
    {
        return round($this->vat / 100, 2);
    }

    /**
     * @param float $vat
     */
    public function setVat(float $vat): void
    {
        $this->vat = round($vat * 100);
    }

    /**
     * @return string
     */
    public function getDineroGuid(): string
    {
        return $this->dineroGuid;
    }

    /**
     * @param string $dineroGuid
     */
    public function setDineroGuid(string $dineroGuid): void
    {
        $this->dineroGuid = $dineroGuid;
    }

    /**
     * @return string
     */
    public function getDineroTimestamp(): string
    {
        return $this->dineroTimestamp;
    }

    /**
     * @param string $dineroTimestamp
     */
    public function setDineroTimestamp(string $dineroTimestamp): void
    {
        $this->dineroTimestamp = $dineroTimestamp;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getAmount() + $this->getVat();
    }
}
