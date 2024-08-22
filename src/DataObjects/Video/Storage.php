<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class Storage implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly float $totalStorageMinutes,
        public readonly int $totalStorageMinutesLimit,
        public readonly int $videoCount,
        public readonly ?string $creator,
    ) {}
}
