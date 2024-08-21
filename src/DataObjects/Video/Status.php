<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

class Status
{
    public function __construct(
        public readonly string $state,
        public readonly string $errorReasonCode,
        public readonly string $errorReasonText,
        public readonly ?string $pctComplete,
    ) {}
}
