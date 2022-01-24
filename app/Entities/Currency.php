<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currency
 *
 * @ORM\Table(name="valuta", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Currency
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
     * @ORM\Column(name="code", type="string", length=11, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=17, scale=2, nullable=false)
     */
    private $value;


}
