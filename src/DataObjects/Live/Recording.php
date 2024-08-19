<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use Szhorvath\CloudflareStream\Enums\RecordingMode;

class Recording
{
    /**
     * @param  array<int, string>|null  $allowedOrigins
     */
    public function __construct(
        public readonly RecordingMode $mode,
        public readonly bool $requireSignedURLs,
        public readonly ?array $allowedOrigins,
        public readonly bool $hideLiveViewerCount,
    ) {}
}
