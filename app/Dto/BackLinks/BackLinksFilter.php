<?php

namespace App\Dto\BackLinks;

use App\Dto\CursorDto;
use App\Entities\User;
use Carbon\Carbon;

class BackLinksFilter extends CursorDto
{
    public const SEARCH = 'search';
    public const USER = 'user';
    public const DOMAIN = 'domain';
    public const NOINDEX = 'noindex';
    public const REL = 'rel';
    public const FOLLOW = 'follow';
    public const INDEXED = 'indexed';
    public const IS_FAILED = 'isFailed';
    public const IS_LOST = 'isLost';
    public const IS_LIVE = 'isLive';
    public const SUBDOMAINS = 'subdomains';
    public const DATE_FROM = 'dateFrom';
    public const DATE_TO = 'dateTo';
    public const RANK_FROM = 'rankFrom';
    public const RANK_TO = 'rankTo';

    public User $user;
    public ?int $domain = null;
    public ?int $rankFrom = null;
    public ?int $rankTo = null;

    public ?string $search = null;
    public ?string $rel = null;

    public ?bool $isFailed = null; //response code not 200
    public ?bool $noindex = null;
    public ?bool $follow = null;
    public ?bool $indexed = null;
    public ?bool $isLost = null;
    public ?bool $isLive = null;
    public ?bool $subdomains = null;

    public ?Carbon $dateFrom = null;
    public ?Carbon $dateTo = null;
}
