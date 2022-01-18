<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * SubscriptionsOrders
 *
 * @ORM\Table(name="subscriptions_orders")
 * @ORM\Entity
 */
class SubscriptionsOrders
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="subscription_id", type="string", length=25, nullable=false)
     */
    private $subscriptionId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=50, nullable=false)
     */
    private $productId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="payment_link", type="text", length=65535, nullable=false)
     */
    private $paymentLink = '0';


}
