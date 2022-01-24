<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Products
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
    private $productname;

    /**
     * @var int
     *
     * @ORM\Column(name="price1", type="integer", nullable=false)
     */
    private $price1;

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
    private $renew1;

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
     * @ORM\Column(name="price2", type="integer", nullable=false)
     */
    private $price2;

    /**
     * @var int
     *
     * @ORM\Column(name="renew2", type="integer", nullable=false)
     */
    private $renew2;

    /**
     * @var int
     *
     * @ORM\Column(name="respons_code", type="integer", nullable=false)
     */
    private $responsCode = '0';

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


}
