<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxDomainGroupsList
 *
 * @ORM\Table(name="trx_domain_groups_list")
 * @ORM\Entity
 */
class TrxDomainGroupsList
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
     * @ORM\Column(name="domain_id", type="integer", nullable=false)
     */
    private $domainId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="domain_group_id", type="integer", nullable=false)
     */
    private $domainGroupId = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdDate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';


}
