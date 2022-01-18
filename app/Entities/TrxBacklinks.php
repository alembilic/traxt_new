<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TrxBacklinks
 *
 * @ORM\Table(name="trx_backlinks")
 * @ORM\Entity
 */
class TrxBacklinks
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
     * @ORM\Column(name="source_url", type="string", length=191, nullable=true)
     */
    private $sourceUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dest_url", type="string", length=191, nullable=true)
     */
    private $destUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="anchortext", type="string", length=191, nullable=true)
     */
    private $anchortext;

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
    private $domainId = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_checked", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $lastChecked = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_found", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $lastFound = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="first_found", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $firstFound = '0000-00-00 00:00:00';

    /**
     * @var int
     *
     * @ORM\Column(name="link_type", type="integer", nullable=false)
     */
    private $linkType = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ignore_link", type="integer", nullable=false)
     */
    private $ignoreLink = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="tld_name", type="string", length=100, nullable=true)
     */
    private $tldName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link_tld", type="string", length=100, nullable=true)
     */
    private $linkTld;

    /**
     * @var int
     *
     * @ORM\Column(name="deleted", type="integer", nullable=false)
     */
    private $deleted = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $createdAt = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $updatedAt = '0000-00-00 00:00:00';

    /**
     * @var int
     *
     * @ORM\Column(name="img_text", type="integer", nullable=false)
     */
    private $imgText;

    /**
     * @var int
     *
     * @ORM\Column(name="header_noindex", type="integer", nullable=false)
     */
    private $headerNoindex = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="header_nofollow", type="integer", nullable=false)
     */
    private $headerNofollow = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="head_noindex", type="integer", nullable=false)
     */
    private $headNoindex;

    /**
     * @var int
     *
     * @ORM\Column(name="head_nofollow", type="integer", nullable=false)
     */
    private $headNofollow;

    /**
     * @var int
     *
     * @ORM\Column(name="rel_nofollow", type="integer", nullable=false)
     */
    private $relNofollow = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="rel_sponsored", type="integer", nullable=false)
     */
    private $relSponsored = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="rel_ugc", type="integer", nullable=false)
     */
    private $relUgc = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="respons", type="string", length=11, nullable=false)
     */
    private $respons;


}
