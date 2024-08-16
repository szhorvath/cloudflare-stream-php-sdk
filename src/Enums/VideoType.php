<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Enums;

enum VideoType: string
{
    case LIVE = 'live';
    case VOD = 'vod';
}
