<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

class Srt
{
    public function __construct(
        public readonly string $passphrase,
        public readonly string $streamId,
        public readonly string $url,
    ) {}
}
