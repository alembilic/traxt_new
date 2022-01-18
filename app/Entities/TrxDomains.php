<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxDomains
 *
 * @ORM\Table(name="trx_domains")
 * @ORM\Entity
 */
class TrxDomains
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
     * @var string
     *
     * @ORM\Column(name="domain_name", type="string", length=191, nullable=false)
     */
    private $domainName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain_url", type="string", length=191, nullable=true)
     */
    private $domainUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain_alias", type="string", length=100, nullable=true)
     */
    private $domainAlias;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=false)
     */
    private $parentId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="domain_type", type="string", length=191, nullable=false)
     */
    private $domainType;

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $createdBy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="thumb_url", type="string", length=100, nullable=true)
     */
    private $thumbUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="domain_status", type="integer", nullable=false, options={"default"="1"})
     */
    private $domainStatus = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="show_dash", type="integer", nullable=false)
     */
    private $showDash = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="deleted", type="integer", nullable=false)
     */
    private $deleted = '0';

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

    /**
     * @var int
     *
     * @ORM\Column(name="validate", type="integer", nullable=false, options={"default"="1"})
     */
    private $validate = 1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="respons_code", type="integer", nullable=true)
     */
    private $responsCode;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_end_point", type="string", length=1000, nullable=false)
     */
    private $domainEndPoint = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="domain_redirect_flow", type="text", length=65535, nullable=true)
     */
    private $domainRedirectFlow;


}
