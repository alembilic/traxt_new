<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BugsImportedUrls
 *
 * @ORM\Table(name="bugs_imported_urls")
 * @ORM\Entity
 */
class BugsImportedUrls
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=400, nullable=false)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_checked", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $lastChecked = '0000-00-00 00:00:00';

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
    private $headNoindex = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="head_nofollow", type="integer", nullable=false)
     */
    private $headNofollow = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="respons_code", type="string", length=11, nullable=false)
     */
    private $responsCode = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="index_state", type="integer", nullable=false)
     */
    private $indexState = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="nohtml", type="integer", nullable=false)
     */
    private $nohtml = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="manual_update_init", type="integer", nullable=true)
     */
    private $manualUpdateInit = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_index_check", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $lastIndexCheck = '0000-00-00 00:00:00';

    /**
     * @var int
     *
     * @ORM\Column(name="waiting_index_respons", type="integer", nullable=false)
     */
    private $waitingIndexRespons = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="redirect_flow", type="text", length=65535, nullable=true)
     */
    private $redirectFlow;

    /**
     * @var string|null
     *
     * @ORM\Column(name="end_point", type="string", length=400, nullable=true)
     */
    private $endPoint;

    /**
     * @var int
     *
     * @ORM\Column(name="canonical", type="integer", nullable=false)
     */
    private $canonical = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="canonical_endpoint", type="string", length=250, nullable=false)
     */
    private $canonicalEndpoint = '';

    /**
     * @var int
     *
     * @ORM\Column(name="attempt", type="integer", nullable=false)
     */
    private $attempt = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="html", type="text", length=0, nullable=true)
     */
    private $html;

    /**
     * @var string|null
     *
     * @ORM\Column(name="js_html", type="text", length=0, nullable=true)
     */
    private $jsHtml;


}
