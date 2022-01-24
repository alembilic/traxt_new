<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity
 */
class Orders
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
     * @ORM\Column(name="subscriptions_orders_id", type="string", length=50, nullable=false)
     */
    private $subscriptionsOrdersId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=50, nullable=false)
     */
    private $productId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_payment_date", type="date", nullable=false, options={"default"="0000-00-00"})
     */
    private $nextPaymentDate = '0000-00-00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="card_withdraw", type="integer", nullable=true)
     */
    private $cardWithdraw = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="transfer_state", type="integer", nullable=false)
     */
    private $transferState = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="vat", type="integer", nullable=false)
     */
    private $vat = '0';

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


}
