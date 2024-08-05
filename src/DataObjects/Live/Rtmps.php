<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

class Rtmps
{
    public function __construct(
        public readonly string $url,
        public readonly string $streamKey,
    ) {}
}
