<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class PolicyActions extends Enum
{
    public const SHOW = 'show';
    public const UPDATE = 'update';
    public const DESTROY = 'destroy';
}
