<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use DateTimeImmutable;

class Watermark
{
    public function __construct(
        public readonly DateTimeImmutable $created,
        public readonly string $downloadedFrom,
        public readonly int $height,
        public readonly string $name,
        public readonly float $opacity,
        public readonly float $padding,
        public readonly string $position,
        public readonly float $scale,
        public readonly int $size,
        public readonly string $uid,
        public readonly int $width,
    ) {}
}
