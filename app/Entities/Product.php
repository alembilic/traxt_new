<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Product
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
     * @ORM\Column(name="productname", type="string", length=50, nullable=false)
     */
    private $productName;

    /**
     * @var int
     *
     * @ORM\Column(name="price1", type="integer", nullable=false)
     */
    private $pricePerMonth;

    /**
     * @var int
     *
     * @ORM\Column(name="price2", type="integer", nullable=false)
     */
    private $priceSubscription;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="public", type="integer", nullable=false)
     */
    private $public;

    /**
     * @var string
     *
     * @ORM\Column(name="mix_id", type="string", length=50, nullable=false)
     */
    private $mixId;

    /**
     * @var int
     *
     * @ORM\Column(name="domains", type="integer", nullable=false)
     */
    private $domains;

    /**
     * @var int
     *
     * @ORM\Column(name="links", type="integer", nullable=false)
     */
    private $links;

    /**
     * @var int
     *
     * @ORM\Column(name="renew1", type="integer", nullable=false)
     */
    private $renew;

    /**
     * @var int
     *
     * @ORM\Column(name="free_trail", type="integer", nullable=false)
     */
    private $freeTrail;

    /**
     * @var int
     *
     * @ORM\Column(name="index_service", type="integer", nullable=false)
     */
    private $indexService;

    /**
     * @var int
     *
     * @ORM\Column(name="renew2", type="integer", nullable=false)
     */
    private $renewSubscribe;

    /**
     * @var int
     *
     * @ORM\Column(name="respons_code", type="integer", nullable=false)
     */
    private $responseCode = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="manual_update", type="integer", nullable=true)
     */
    private $manualUpdate = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="render_service", type="integer", nullable=false)
     */
    private $renderService = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="canonical", type="integer", nullable=false)
     */
    private $canonical = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="bureau", type="integer", nullable=false)
     */
    private $bureau = '0';

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
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @return int
     */
    public function getPricePerMonth(): int
    {
        return $this->pricePerMonth;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getPublic(): int
    {
        return $this->public;
    }

    /**
     * @return string
     */
    public function getMixId(): string
    {
        return $this->mixId;
    }

    /**
     * @return int
     */
    public function getDomains(): int
    {
        return $this->domains;
    }

    /**
     * @return int
     */
    public function getLinks(): int
    {
        return $this->links;
    }

    /**
     * @return int
     */
    public function getRenew(): int
    {
        return $this->renew;
    }

    /**
     * @return int
     */
    public function getFreeTrail(): int
    {
        return $this->freeTrail;
    }

    /**
     * @return int
     */
    public function getIndexService(): int
    {
        return $this->indexService;
    }

    /**
     * @return int
     */
    public function getPricePeriod(): int
    {
        return $this->priceSubscription;
    }

    /**
     * @return int
     */
    public function getRenewSubscribe(): int
    {
        return $this->renewSubscribe;
    }

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return int|null
     */
    public function getManualUpdate()
    {
        return $this->manualUpdate;
    }

    /**
     * @return int
     */
    public function getRenderService()
    {
        return $this->renderService;
    }

    /**
     * @return int
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @return int
     */
    public function getBureau()
    {
        return $this->bureau;
    }
}
