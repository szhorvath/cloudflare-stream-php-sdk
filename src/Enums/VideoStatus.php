<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Enums;

enum VideoStatus: string
{
    case PENDING_UPLOAD = 'pendingupload';
    case DOWNLOADING = 'downloading';
    case QUEUED = 'queued';
    case IN_PROGRESS = 'inprogress';
    case READY = 'ready';
    case ERROR = 'error';
}
