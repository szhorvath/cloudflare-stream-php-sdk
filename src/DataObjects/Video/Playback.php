<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

class Playback
{
    public function __construct(
        public readonly string $hls,
        public readonly string $dash,
    ) {}
}
