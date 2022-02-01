<?php

namespace App\Entities;

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

    /**
     * @param string $configName
     * @param string $configValue
     */
    public function __construct(string $configName, string $configValue)
    {
        $this->configName = $configName;
        $this->configValue = $configValue;
    }

    /**
     * @return string
     */
    public function getConfigName(): string
    {
        return $this->configName;
    }

    /**
     * @param string $configName
     */
    public function setConfigName(string $configName): void
    {
        $this->configName = $configName;
    }

    /**
     * @return string
     */
    public function getConfigValue(): string
    {
        return $this->configValue;
    }

    /**
     * @param string $configValue
     */
    public function setConfigValue(string $configValue): void
    {
        $this->configValue = $configValue;
    }
}
