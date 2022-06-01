<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFeature
 *
 * @ORM\Table(name="product_features")
 *
 * @ORM\Entity
 */
class ProductFeature
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="feature_name", type="string", length=50, nullable=false)
     */
    private $featureName;

    /**
     * @var string
     *
     * @ORM\Column (name="feature_description", type="string", length=50, nullable=false)
     */
    private $featureDescription;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     *
     * @ORM\JoinColumn(name="product_feature_id", referencedColumnName="id")
     */
    private $product;
}
