<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxDbcache
 *
 * @ORM\Table(name="trx_dbcache", uniqueConstraints={@ORM\UniqueConstraint(name="dbcache_url_unique", columns={"url"})})
 * @ORM\Entity
 */
class TrxDbcache
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
     * @ORM\Column(name="url", type="string", length=191, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text", length=0, nullable=false)
     */
    private $html;

    /**
     * @var string
     *
     * @ORM\Column(name="md5", type="string", length=191, nullable=false)
     */
    private $md5;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $createdAt = '0000-00-00 00:00:00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="respons_code", type="string", length=11, nullable=true)
     */
    private $responsCode;


}
