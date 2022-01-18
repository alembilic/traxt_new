<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxInviteTemplates
 *
 * @ORM\Table(name="trx_invite_templates")
 * @ORM\Entity
 */
class TrxInviteTemplates
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
     * @ORM\Column(name="template_name", type="string", length=255, nullable=false)
     */
    private $templateName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="template_desc", type="text", length=65535, nullable=true)
     */
    private $templateDesc;

    /**
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy = '0';

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
