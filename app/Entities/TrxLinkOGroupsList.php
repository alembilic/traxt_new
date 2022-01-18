<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxLinkOGroupsList
 *
 * @ORM\Table(name="trx_link_o_groups_list")
 * @ORM\Entity
 */
class TrxLinkOGroupsList
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
     * @ORM\Column(name="link_group_id", type="integer", nullable=false)
     */
    private $linkGroupId = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="overview_id", type="integer", nullable=false)
     */
    private $overviewId = '0';

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
