<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Download;

use Szhorvath\CloudflareStream\Enums\DownloadStatus;

class DefaultDownload
{
    public function __construct(
        public readonly DownloadStatus $status,
        public readonly string $url,
        public readonly int $percentComplete,
    ) {}
}
