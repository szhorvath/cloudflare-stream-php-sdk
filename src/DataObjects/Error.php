<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects;

use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class Error
{
    use CanBeHydrated;

    public function __construct(
        public readonly int $code,
        public readonly string $message,
    ) {}
}
