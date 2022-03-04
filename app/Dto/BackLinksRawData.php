<?php

namespace App\Dto;

use Carbon\Carbon;

/**
 * BackLinks Raw data.
 */
class BackLinksRawData extends BaseDtoWrapper
{
    public const DOMAIN_NAME = 'domainName';
    public const SOURCE_URL = 'sourceUrl';
    public const DEST_URL = 'destUrl';
    public const ANCHOR_TEXT = 'anchorText';
    public const TLD_NAME = 'tldName';
    public const TLD_LINK = 'tldLink';
    public const IMG_TEXT = 'imgText';
    public const HEADER_NOINDEX = 'headerNoindex';
    public const HEADER_NOFOLLOW = 'headerNofollow';
    public const HEAD_NOINDEX = 'headNoindex';
    public const HEAD_NOFOLLOW = 'headNofollow';
    public const REL_NOINDEX = 'relNoindex';
    public const REL_NOFOLLOW = 'relNofollow';
    public const REL_UGC = 'relUgc';
    public const REL_SPONSORED = 'relSponsored';
    public const RESPONSE = 'response';
    public const STATUS = 'status';
    public const LAST_CHECKED = 'lastChecked';
    public const LAST_FOUND = 'lastFound';
    public const FIRST_FOUND = 'firstFound';
    public const LINK_TYPE = 'linkType';
    public const RANK = 'rank';
    public const IS_LOST = 'isLost';
    public const ALT = 'alt';

    public string $domainName;
    public string $sourceUrl;

    public ?string $destUrl = null;
    public ?string $anchorText = null;
    public ?string $tldName = null;
    public ?string $tldLink = null;
    public ?string $imgText = null;

    public ?bool $headerNoindex = true;
    public ?bool $headerNofollow = true;
    public ?bool $headNoindex = true;
    public ?bool $headNofollow = true;
    public ?bool $relNoindex = true;
    public ?bool $relNofollow = true;
    public ?bool $relUgc = null;
    public ?bool $relSponsored = null;
    public ?bool $isLost = null;
    public ?bool $alt = null;

    public ?int $status = 1;
    public ?int $linkType = 1;
    public ?int $response = 200;
    public ?int $rank = null;

    public ?Carbon $lastChecked = null;
    public ?Carbon $lastFound = null;
    public ?Carbon $firstFound = null;

    /**
     * @return string
     */
    public function getSearchKey(): string
    {
        return $this->sourceUrl . '-' . $this->destUrl;
    }
}
