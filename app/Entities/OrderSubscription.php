<?php

namespace App\Entities;

use App\Core\EntityManagerFresher;
use App\Enums\SubscriptionTypes;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * OrderSubscription
 *
 * @ORM\Table(name="subscriptions_orders")
 * @ORM\Entity
 */
class OrderSubscription
{
    use EntityManagerFresher;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="activeSubscriptions")
     *
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="subscription_id", type="string", length=25, nullable=false)
     */
    private $subscriptionId = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=50, nullable=false)
     */
    private $productId = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_link", type="text", length=65535, nullable=false)
     */
    private $paymentLink = 0;

    /**
     * @param User $user User
     * @param Product $product Product
     */
    public function __construct(User $user, Product $product, string $type)
    {
        $this->user = $user;
        $this->productId = $product->getId() . '-' . $type;
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
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    /**
     * @param string $subscriptionId
     */
    public function setSubscriptionId(string $subscriptionId): void
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getPaymentLink(): string
    {
        return $this->paymentLink;
    }

    /**
     * @param string $paymentLink
     */
    public function setPaymentLink(string $paymentLink): void
    {
        $this->paymentLink = $paymentLink;
    }

    /**
     * @return Product|null
     *
     * @throws BindingResolutionException
     */
    public function getProduct(): ?Product
    {
        $mixId = explode('-', $this->productId)[0];
        if (!$mixId) {
            return null;
        }

        return $this->getEntityManager()->getRepository(Product::class)->findOneBy(['mixId' => $mixId]);
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        $type = intval(explode('-', $this->productId)[1] ?? 0);
        if (!$type) {
            return null;
        }

        return $type === 1 ? SubscriptionTypes::ONCE : SubscriptionTypes::SUBSCRIBE;
    }

    /**
     * @return integer
     *
     * @throws BindingResolutionException
     */
    public function getPeriod(): int
    {
        if (!$this->getProduct()) {
            return 0;
        }
        return $this->getType() === SubscriptionTypes::ONCE
            ? $this->getProduct()->getRenew()
            : $this->getProduct()->getRenewSubscribe();
    }

    /**
     * @return float
     *
     * @throws BindingResolutionException
     */
    public function getPrice(): float
    {
        $product = $this->getProduct();
        if (!$product) {
            return 0.00;
        }

        return ($this->getType() === SubscriptionTypes::ONCE
            ? $product->getPricePerMonth()
            : $product->getPriceSubscription()) / 100;
    }

    /**
     * @return float
     *
     * @throws BindingResolutionException
     */
    public function getVat(): float
    {
        $product = $this->getProduct();
        if (!$product) {
            return 0.00;
        }

        if (!$this->user->getVatValid() || $this->user->getVatValid() === 'DK') {
            return ($this->getType() === SubscriptionTypes::ONCE
                ? $product->getPricePerMonth()
                : $product->getPriceSubscription()) / 100 * 0.25;
        }

        return 0;
    }

    /**
     * @return float
     *
     * @throws BindingResolutionException
     */
    public function getTotal(): float
    {
        return $this->getPrice() + $this->getVat();
    }
}
