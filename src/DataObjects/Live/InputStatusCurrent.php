<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use DateTimeImmutable;

class InputStatusCurrent
{
    public function __construct(
        public readonly string $ingestProtocol,
        public readonly string $reason,
        public readonly string $state,
        public readonly DateTimeImmutable $statusEnteredAt,
        public readonly DateTimeImmutable $statusLastSeen,
    ) {}
}
