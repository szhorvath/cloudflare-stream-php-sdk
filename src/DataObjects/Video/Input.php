<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

class Input
{
    public function __construct(
        public readonly int $width,
        public readonly int $height,
    ) {}
}
