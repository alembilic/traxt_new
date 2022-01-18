<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * NegativList
 *
 * @ORM\Table(name="negativ_list")
 * @ORM\Entity
 */
class NegativList
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
     * @ORM\Column(name="domain", type="string", length=400, nullable=false)
     */
    private $domain;


}
