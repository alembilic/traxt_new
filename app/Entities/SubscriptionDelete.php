<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * SubscriptionDelete
 *
 * @ORM\Table(name="subscription_delete")
 * @ORM\Entity
 */
class SubscriptionDelete
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
     * @var string
     *
     * @ORM\Column(name="sub_id", type="string", length=50, nullable=false)
     */
    private $subId;


}
