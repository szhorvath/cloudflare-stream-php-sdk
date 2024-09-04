<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Enums;

enum DownloadStatus: string
{
    case IN_PROGRESS = 'inprogress';
    case READY = 'ready';
}
