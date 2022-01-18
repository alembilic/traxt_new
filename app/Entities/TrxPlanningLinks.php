<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxPlanningLinks
 *
 * @ORM\Table(name="trx_planning_links")
 * @ORM\Entity
 */
class TrxPlanningLinks
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link_name", type="string", length=191, nullable=true)
     */
    private $linkName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link_url", type="string", length=191, nullable=true)
     */
    private $linkUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $createdBy;

    /**
     * @var int
     *
     * @ORM\Column(name="domain_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $domainId;

    /**
     * @var int
     *
     * @ORM\Column(name="link_type", type="integer", nullable=false)
     */
    private $linkType = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="tld_name", type="string", length=100, nullable=true)
     */
    private $tldName;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $price = 0.00;

    /**
     * @var string|null
     *
     * @ORM\Column(name="notes", type="text", length=65535, nullable=true)
     */
    private $notes;

    /**
     * @var int
     *
     * @ORM\Column(name="dr_number", type="integer", nullable=false)
     */
    private $drNumber = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="traffic", type="integer", nullable=false)
     */
    private $traffic = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';


}
