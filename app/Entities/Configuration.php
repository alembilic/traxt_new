<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 *
 * @ORM\Table(name="configuration")
 * @ORM\Entity
 */
class Configuration
{
    /**
     * @var string
     *
     * @ORM\Column(name="config_name", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $configName;

    /**
     * @var string
     *
     * @ORM\Column(name="config_value", type="string", length=64, nullable=false)
     */
    private $configValue;


}
