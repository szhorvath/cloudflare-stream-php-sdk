<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

class WebRTC
{
    public function __construct(
        public readonly string $url,
    ) {}
}
