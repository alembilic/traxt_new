<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * BugsExternalLinks
 *
 * @ORM\Table(name="bugs_external_links")
 * @ORM\Entity
 */
class BugsExternalLinks
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
     * @ORM\Column(name="bug_id", type="integer", nullable=false)
     */
    private $bugId;

    /**
     * @var int
     *
     * @ORM\Column(name="id_imported_urls", type="integer", nullable=false)
     */
    private $idImportedUrls;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dest_url", type="text", length=65535, nullable=true)
     */
    private $destUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="anchortext", type="string", length=400, nullable=true)
     */
    private $anchortext;

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
     * @var int|null
     *
     * @ORM\Column(name="img_text", type="integer", nullable=true)
     */
    private $imgText;

    /**
     * @var int
     *
     * @ORM\Column(name="ignore_link", type="integer", nullable=false)
     */
    private $ignoreLink = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="rel_nofollow", type="integer", nullable=true)
     */
    private $relNofollow;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rel_sponsored", type="integer", nullable=true)
     */
    private $relSponsored;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rel_ugc", type="integer", nullable=true)
     */
    private $relUgc;

    /**
     * @var int|null
     *
     * @ORM\Column(name="found", type="integer", nullable=true)
     */
    private $found;

    /**
     * @var int
     *
     * @ORM\Column(name="js_render", type="integer", nullable=false)
     */
    private $jsRender = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="respons_code", type="integer", nullable=true)
     */
    private $responsCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="respons_last_checked", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $responsLastChecked = '0000-00-00 00:00:00';

    /**
     * @var int
     *
     * @ORM\Column(name="redirects", type="integer", nullable=false)
     */
    private $redirects = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="redirect_flow", type="text", length=65535, nullable=true)
     */
    private $redirectFlow;

    /**
     * @var string|null
     *
     * @ORM\Column(name="end_point", type="text", length=65535, nullable=true)
     */
    private $endPoint;


}
