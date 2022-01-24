<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="smallint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=50, nullable=false)
     */
    private $groupName;

    /**
     * @var bool
     *
     * @ORM\Column(name="group_level", type="boolean", nullable=false)
     */
    private $groupLevel;


}
