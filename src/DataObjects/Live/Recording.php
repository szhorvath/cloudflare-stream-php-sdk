<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

class Recording
{
    public function __construct(
        public readonly string $mode,
        public readonly bool $requireSignedURLs,
        public readonly ?array $allowedOrigins,
        public readonly bool $hideLiveViewerCount,
    ) {}
}
